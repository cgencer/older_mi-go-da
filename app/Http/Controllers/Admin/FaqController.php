<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CouponRule;
use App\Models\Faq;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'role:SuperAdmin'])->only(
            [
                'add',
                'edit',
                'save',
                'remove',
            ]);
    }

    public function index()
    {
        return view('admin.modules.faq.index');
    }

    public function indexAjax()
    {
        return datatables()->of(Faq::query())->only(
            [
                'id',
                'title',
                'icon',
                'type',
                'created_at',
                'updated_at',
                'action',
            ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'icon', 'type', 'action'])
            ->addColumn(
                'title', function (Faq $data) {
                return $data->title;
            })
            ->addColumn(
                'id', function (Faq $data) {
                return ' <div class="checkbox"><input id="selectableItem_' . $data->id . '" type="checkbox" value="' . $data->id . '">
                 <label for="selectableItem_' . $data->id . '">#' . $data->id . '</label>
                 </div>';
            })
            ->addColumn(
                'type', function (Faq $data) {

                    switch ($data->type) {

                        case 'USER':
                            $type = '<td><span class="badge badge-pill badge-gradient-success">Migoda User</span></td>';
                            break;
                        case 'HOTEL':
                            $type = '<td><span class="badge badge-pill badge-info">Migoda Hotels</span></td>';
                            break;
                        case 'PRIVACY':
                            $type = '<td><span class="badge badge-pill badge-warning">Migoda Privacy</span></td>';
                            break;
                        case 'HOTEL_PRIVACY':
                            $type = '<td><span class="badge badge-pill badge-gradient-warning">MigodaHotel Privacy</span></td>';
                            break;

                    }

                return $type;
            })
            ->addColumn(
                'created_at', function (Faq $data) {
                if (!empty($data->created_at)) {
                    $created_at = $data->created_at->format('d-m-Y H:i:s');
                } else {
                    $created_at = "";
                }
                return ($created_at);
            })
            ->addColumn(
                'updated_at', function (Faq $data) {
                if (!empty($data->updated_at)) {
                    $updated_at = $data->updated_at->format('d-m-Y H:i:s');
                } else {
                    $updated_at = "";
                }
                return ($updated_at);
            })
            ->addColumn(
                'action', function (Faq $data) {
                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="' . route('admin.faq.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';
                $action .= '<a href="' . route('admin.faq.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                $action .= '</div>';

                return $action;
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->orderColumn('title', function ($query, $order) {
                $query->orderBy('title', $order);
            })
            ->orderColumn('type', function ($query, $order) {
                $query->orderBy('type', $order);
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
            })
            ->orderColumn('updated_at', function ($query, $order) {
                $query->orderBy('updated_at', $order);
            })
            ->toJson();
    }

    public function edit($id)
    {
        $data = Faq::findOrFail($id);
        return view('admin.modules.faq.edit', compact('data'))->render();
    }

    public function save(Request $request, $id)
    {
        $updateData = Faq::findOrFail($id);
        $oldData = $updateData->toArray();
        $attributes = [
            'title' => 'Title',
            'icon' => 'Icon White',
            'icon2' => 'Icon Colored',
            'content' => 'Content',
            'type' => 'Type',
            'position' => 'Position',
        ];
        $messages = [];
        $rules = [
            'title' => 'required|min:1',
            'content' => 'required|min:1',
            'type' => 'required|min:1',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $updateData->title = $request->title;
        $updateData->icon = $request->icon;
        $updateData->icon2 = $request->icon2;
        $updateData->content = $request->content;
        $updateData->type = $request->type;
        $updateData->position = $request->position;
        $save = $updateData->save();

        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => 'Updated!'
            ]
        ];

        return redirect()->back()->with($alert);
    }

    public function add(Request $request)
    {
        if (!isset($request->submitted) || empty($request->submitted)) {
            return view('admin.modules.faq.add')->render();
        }
        $newData = new Faq();
        $attributes = [
            'title' => 'Title',
            'icon' => 'Icon White',
            'icon2' => 'Icon Colored',
            'content' => 'Content',
            'type' => 'Type',
            'position' => 'Position',
        ];
        $messages = [];
        $rules = [
            'title' => 'required|min:1',
            'content' => 'required|min:1',
            'type' => 'required|min:1',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $newData->title = $request->title;
        $newData->icon = $request->icon;
        $newData->icon2 = $request->icon2;
        $newData->content = $request->content;
        $newData->type = $request->type;
        $newData->position = $request->position;
        $save = $newData->save();

        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => 'Added!'
            ]
        ];

        return redirect()->back()->with($alert);
    }

    public function remove($id)
    {
        if (Faq::destroy($id)) {
            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Deleted!'
                ]
            ];

            return redirect(route('admin.faq.index'))->with($alert);
        } else {
            $alert = [
                'alert' => [
                    'status' => 'danger',
                    'message' => __('txt.error_one')
                ]
            ];

            return redirect(route('admin.faq.index'))->with($alert);
        }
    }
}
