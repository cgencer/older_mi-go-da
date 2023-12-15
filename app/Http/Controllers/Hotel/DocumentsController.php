<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Documents;
use App\Models\Hotels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Plank\Mediable\Facades\MediaUploader;
use App\Notifications\AlertTeam;
use Illuminate\Support\Facades\Notification;


class DocumentsController extends Controller
{
    public function index(Request $request)
    {
        return view('hotel_admin.modules.documents.index');
    }

    public function indexAjax(Request $request)
    {
        $userID = Auth::guard('user')->user()->id;
        $getHotel = Hotels::where('user_id', $userID)->first();

        $query = Documents::query()->where('hotelId', $getHotel->id)->where('hotel_preview', 1)->orderByRaw('FIELD(status,2,0,1,3)');

        return datatables()->of($query)->only(
            [
                'id',
                'name',
                'description',
                'creator',
                'status',
                'type',
                'created_at',
                'updated_at',
                'action',
            ]
        )->startsWithSearch()->escapeColumns()->rawColumns(['id', 'name', 'status', 'action', 'creator'])
            ->addColumn(
                'id',
                function (Documents $data) {
                    return $data->id;
                }
            )
            ->addColumn(
                'name',
                function (Documents $data) {
                    return $data->name;
                }
            )
            ->addColumn(
                'description',
                function (Documents $data) {
                    return $data->description;
                }
            )
            ->addColumn(
                'creator', function (Documents $data) {
                if ($data->userID == null) {
                    $creator = "<span class='text-semibold m-l-5' style='color:#8b8b8b'> ADMIN </span>";
                } else {
                    $creator = "<span class='text-semibold m-l-5' style='color:#ff80d7'> HOTEL </span>";
                }
                return ($creator);
            })
            ->addColumn(
                'status',
                function (Documents $data) {
                    if ($data->status == 0) {
                        $status = "<span class='badge badge-warning'><i class='fa fa-clock-o'></i> ".trans('txt.title_pending_approval')."</span>";
                    } else if ($data->status == 1) {
                        $status = "<span class='badge badge-success'> <i class='fa fa-check'></i> ".trans('txt.title_document_approved')." </span>";
                    } else if ($data->status == 2) {
                        $status = "<span class='badge badge-danger'> <i class='fa fa-times'></i> ".trans('txt.title_document_rejected')." </span>";
                    } else {
                        $status = "<span class='badge badge-info'> <i class='fa fa-briefcase'></i> ".trans('txt.title_document_admin')." </span>";
                    }
                    return ($status);
                }
            )
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
                'created_at',
                function (Documents $data) {
                    if (!empty($data->created_at)) {
                        $created_at = $data->created_at->format('d-m-Y H:i:s');
                    } else {
                        $created_at = "";
                    }
                    return ($created_at);
                }
            )
            ->addColumn(
                'updated_at',
                function (Documents $data) {
                    if (!empty($data->updated_at)) {
                        $updated_at = $data->updated_at->format('d-m-Y H:i:s');
                    } else {
                        $updated_at = "";
                    }
                    return ($updated_at);
                }
            )
            ->addColumn(
                'action',
                function (Documents $data) {
                    $action = '<div class="text-center font-size-16 btn-group">';
                    $action .= '<a href="' . route('hotel_admin.documents.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';
                    $action .= '</div>';

                    return $action;
                }
            )
            ->toJson();
    }

    public static function add()
    {
        return view('hotel_admin.modules.documents.add')->render();
    }

    public function edit($id)
    {
        $document = Documents::findOrFail($id);
        return view('hotel_admin.modules.documents.edit', compact('document'))->render();
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
        $userID = Auth::guard('user')->user()->id;
        $hotelId = Hotels::where('user_id', $userID)->first();

        $setDocument = new Documents;
        $setDocument->userID = $userID;
        $setDocument->hotelId = $hotelId->id;
        $setDocument->name = $request->name;
        $setDocument->type = $request->type;
        $setDocument->description = $request->description;;
        $setDocument->creator = 'HOTEL';

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

        if ($setDocument->type == 1) {
            $type = trans('txt.add_document_type_service');
        } else if ($setDocument->type == 2) {
            $type = trans('txt.add_document_type_commercial');
        } else if ($setDocument->type == 3) {
            $type = trans('txt.add_document_type_insurance');
        }else if($setDocument->type == 4){
            $type = 'Other';           
        }

        $data = [
            'hotel' => $hotelId->name,
            'type' => $type,
            'name' => $setDocument->name,
            'date' => $setDocument->created_at,
            'url' => route('admin.documents.edit', ['id' => $setDocument->id])
        ];

        Notification::route('mail', 'register@migodahotels.com')->notify(new AlertTeam($data));
        
        return redirect(route('hotel_admin.documents.edit', ['id' => $setDocument->id]))->with($alert);
    }

    public static function update(Request $request, $id)
    {
        $setDocument = Documents::findOrFail($id);

        if (isset($request->file)) {
            $attributes = [
                'name' => 'Name',
                'file.*' => 'Files',
            ];
            $rules = [
                'name' => 'required|min:1',
                'file.*' => 'required|mimes:pdf,xls,doc,docx,pptx,pps,jpeg,bmp,png,gif|max:20000',
            ];
        } else {
            $attributes = [
                'name' => 'Name',
                'description' => 'Description',
            ];
            $rules = [
                'name' => 'required|min:1',
                'description' => 'required|min:1|max:255',
            ];
        }

        $messages = [];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $userID = Auth::guard('user')->user()->id;

        $setDocument->userID = $userID;
        $setDocument->name = $request->name;
        $setDocument->type = $request->type;
        $setDocument->description = $request->description;
        if (isset($request->file)) {
            $setDocument->status = 0;
        }
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

        return redirect(route('hotel_admin.documents.edit', ['id' => $setDocument->id]))->with($alert);
    }
}
