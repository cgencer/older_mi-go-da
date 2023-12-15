<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Documents;
use App\Models\Hotels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Plank\Mediable\Facades\MediaUploader;


class DocumentsController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.modules.documents.index');
    }

    public function indexAjax(Request $request)
    {

        $query = Documents::query();

        return datatables()->of($query)->only(
            [
                'id',
                'name',
                'hotel_id',
                'hotel_name',
                'userID',
                'description',
                'creator',
                'status',
                'type',
                'created_at',
                'updated_at',
                'action',
            ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'name', 'status', 'action', 'creator', 'type'])
            ->addColumn(
                'id', function (Documents $data) {
                return ' <div class="checkbox"><input id="selectableItem_' . $data->id . '" type="checkbox" value="' . $data->id . '">
                 <label for="selectableItem_' . $data->id . '">#' . $data->id . '</label>
                 </div>';
            })
            ->addColumn(
                'name', function (Documents $data) {
                return $data->name;
            })
            ->addColumn(
                'hotel_name', function (Documents $data) {
                return $data->hotels()->count() > 0 ? $data->hotels()->get()->first()->name : '-';
            })
            ->addColumn(
                'description', function (Documents $data) {
                return $data->description;
            })
            ->addColumn(
                'creator', function (Documents $data) {
                if ($data->creator == 'ADMIN') {
                    $creator = "<span class='text-info text-semibold m-l-5'> ADMIN </span>";
                } else {
                    $creator = "<span class='text-success text-semibold m-l-5'> HOTEL </span>";
                }
                return ($creator);
            })
            ->addColumn(
                'status', function (Documents $data) {
                if ($data->status == 0) {
                    $status = "<span class='badge badge-warning'><i class='fa fa-clock-o'></i> Pending Approval</span>";
                } else if ($data->status == 1) {
                    $status = "<span class='badge badge-success'> <i class='fa fa-check'></i> Approved </span>";
                } else if ($data->status == 3) {
                    $status = "<span class='badge badge-info'> <i class='fa fa-briefcase'></i> Added by Admin </span>";
                } else {
                    $status = "<span class='badge badge-danger'> <i class='fa fa-times'></i> Rejected </span>";
                }
                return ($status);
            })
            ->addColumn(
                'type',
                function (Documents $data) {
                    if ($data->type == 1) {
                        $type = trans('txt.add_document_type_service');
                    } else if ($data->type == 2) {
                        $type = trans('txt.add_document_type_commercial');
                    } else if ($data->type == 3) {
                        $type = trans('txt.add_document_type_insurance');
                    }else if($data->type == 4){
                        $type = trans('txt.add_document_type_other');
                    }
                    return ($type);
                }
            )
            ->addColumn(
                'created_at', function (Documents $data) {
                if (!empty($data->created_at)) {
                    $created_at = $data->created_at->format('d-m-Y H:i:s');;
                } else {
                    $created_at = "";
                }
                return ($created_at);
            })
            ->addColumn(
                'updated_at', function (Documents $data) {
                if (!empty($data->updated_at)) {
                    $updated_at = $data->updated_at->format('d-m-Y H:i:s');;
                } else {
                    $updated_at = "";
                }
                return ($updated_at);
            })
            ->addColumn(
                'action', function (Documents $data) {
                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="' . route('admin.documents.edit', $data->id) . '" class="btn btn-success" title="Details"><i class="fa fa-pencil"></i></a>';
                $action .= '<a href="' . route('admin.documents.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                $action .= '</div>';

                return $action;
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('name', $order);
            })
            ->orderColumn('hotel_name', function ($query, $order) {
                $query->orderBy(function ($query) {
                    $query->select('name')
                        ->from('hotels')
                        ->whereColumn('hotelId', 'hotels.id')
                        ->limit(1);
                }, $order);
            })
            ->orderColumn('description', function ($query, $order) {
                $query->orderBy('description', $order);
            })
            ->orderColumn('creator', function ($query, $order) {
                $query->orderBy('creator', $order);
            })
            ->orderColumn('status', function ($query, $order) {
                $query->orderBy('status', $order);
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
            })
            ->orderColumn('updated_at', function ($query, $order) {
                $query->orderBy('updated_at', $order);
            })
            ->toJson();
    }

    public static function add()
    {
        $hotels = Hotels::all();
        $new_hotels = array();
        foreach ($hotels as $hotel) {
            $new_hotels[$hotel['id']] = $hotel['name'] . ' ('. str_replace('s/n ', '', $hotel['city']) .')';
        }
        return view('admin.modules.documents.add', compact('new_hotels'))->render();
    }

    public function edit($id)
    {
        $hotels = Hotels::all();
        $new_hotels = array();
        foreach ($hotels as $hotel) {
            $new_hotels[$hotel['id']] = $hotel['name'] . ' ('. str_replace('s/n ', '', $hotel['city']) .')';
        }
        $hotelInformation = Documents::with(['hotels'])->where('id', $id)->first();
        $document = Documents::findOrFail($id);

        return view('admin.modules.documents.edit', compact('document', 'hotelInformation', 'new_hotels'))->render();
    }

    public static function store(Request $request)
    {

        $setDocument = array();

        $attributes = [
            'name' => 'Name',
            'file.*' => 'sometimes|mimes:pdf,xls,doc,docx,pptx,pps,jpeg,bmp,png,gif|max:20000',
        ];
        $rules = [
            'name' => 'required|min:1',
            'file.*' => 'sometimes|mimes:pdf,xls,doc,docx,pptx,pps,jpeg,bmp,png,gif|max:20000',
        ];
        $messages = [];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }


        $setDocument = new Documents;
        $setDocument->hotelId = $request->hotel;
        $setDocument->name = $request->name;
        $setDocument->description = $request->description;
        $setDocument->comment = $request->comment;
        $setDocument->type = $request->type;
        $setDocument->status = 3; //Yeni eklenen statü, 3= Local Document(Admin bir döküman oluşturduğunda bu statüde görünür.)
        $setDocument->adminId = Auth::guard('admin')->user()->id;
        $setDocument->creator = 'ADMIN';
        $setDocument->hotel_preview = $request->hotel_preview == 'on' ? 1 : 0;

        $setDocument->save();

        foreach ($request->file('file') as $file) {
            $media = MediaUploader::fromSource($file)
                ->toDestination('uploads', 'documents')
                ->upload();

            $setDocument->attachMedia($media, 'file');
        }

        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => 'New Document Save Successful.'
            ]
        ];

        return redirect(route('admin.documents.edit', ['id' => $setDocument->id]))->with($alert);
    }

    public static function update(Request $request, $id)
    {

        $setDocument = Documents::findOrFail($id);

        if (isset($request->file)) {
            $attributes = [
                'name' => 'Name',
                'reject_reason' => 'Reject Reason',
                'file.*' => 'Files',
            ];
            $rules = [
                'name' => 'required|min:1',
                'file.*' => 'required|mimes:pdf,xls,doc,docx,pptx,pps,jpeg,bmp,png,gif|max:20000',
                'reject_reason' => ($request->status == 2) ? 'required|min:1|max:255' : '',
            ];
        } else {
            $attributes = [
                'name' => 'Name',
                'reject_reason' => 'Reject Reason',
            ];
            $rules = [
                'name' => 'required|min:1',
                'reject_reason' => ($request->status == 2) ? 'required|min:1|max:255' : '',
            ];
        }

        $messages = [];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $setDocument->description = $request->description;
        $setDocument->name = $request->name;
        $setDocument->status = isset($request->status) ? $request->status : 3;
        $setDocument->reject_reason = $request->reject_reason;
        $setDocument->comment = $request->comment;
        $setDocument->type = $request->type;
        $setDocument->hotel_preview = $request->hotel_preview == 'on' ? 1 : 0;

        $setDocument->save();


        if (isset($request->file)) {

            if ($setDocument->files) {
                foreach ($setDocument->files as $file) {
                    $setDocument->detachMedia($file);
                }
            }

            foreach ($request->file('file') as $file) {
                $media = MediaUploader::fromSource($file)
                    ->toDestination('uploads', 'documents')
                    ->upload();
                $setDocument->attachMedia($media, 'file');
            }
        }

        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => 'Document Update Successful.'
            ]
        ];

        return redirect(route('admin.documents.edit', ['id' => $setDocument->id]))->with($alert);
    }

    public static function remove($id)
    {
        $documents = Documents::findOrFail($id);
        if (Documents::destroy($id)) {
            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Documents Succesfully Deleted!'
                ]
            ];
            return redirect(route('admin.documents.index'))->with($alert);
        } else {
            $alert = [
                'alert' => [
                    'status' => 'danger',
                    'message' => __('txt.error_one')
                ]
            ];

            return redirect(route('admin.documents.index'))->with($alert);
        }
    }

}
