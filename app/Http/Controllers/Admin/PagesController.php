<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
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
        return view('admin.modules.pages.index');
    }

    public function indexAjax()
    {
        return datatables()->of(Pages::query())->only(
            [
                'id',
                'title',
                'slug',
                'created_at',
                'updated_at',
                'action',
            ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'action'])
            ->addColumn(
                'title', function (Pages $data) {
                return $data->title;
            })
            ->addColumn(
                'slug', function (Pages $data) {
                return $data->slug;
            })
            ->addColumn(
                'created_at', function (Pages $data) {
                if (!empty($data->created_at)) {
                    $created_at = $data->created_at->format('d-m-Y H:i:s');
                } else {
                    $created_at = "";
                }
                return ($created_at);
            })
            ->addColumn(
                'updated_at', function (Pages $data) {
                if (!empty($data->updated_at)) {
                    $updated_at = $data->updated_at->format('d-m-Y H:i:s');
                } else {
                    $updated_at = "";
                }
                return ($updated_at);
            })
            ->addColumn(
                'action', function (Pages $data) {
                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="' . route('admin.pages.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';
                $action .= '<a href="' . route('admin.pages.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                $action .= '</div>';

                return $action;
            })->toJson();
    }

    public function edit($id)
    {
        $data = Pages::findOrFail($id);
        return view('admin.modules.pages.edit', compact('data'))->render();
    }

    public function save(Request $request, $id)
    {
        $updateData = Pages::findOrFail($id);
        $oldData = $updateData->toArray();
        $attributes = [
            'title' => 'Title',
            'slug' => 'Slug',
            'icon' => 'Icon',
        ];
        $messages = [];
        $rules = [
            'title' => 'required|min:1',
            'slug' => 'required|min:1',
            'content' => 'required|min:1',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $updateData->title = $request->title;
        $updateData->slug = $request->slug;
        $updateData->content = $request->content;
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
            return view('admin.modules.pages.add')->render();
        }
        $newData = new Pages();
        $attributes = [
            'title' => 'Title',
            'slug' => 'Slug',
            'content' => 'Content',
        ];
        $messages = [];
        $rules = [
            'title' => 'required|min:1',
            'slug' => 'required|min:1',
            'content' => 'required|min:1',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $newData->title = $request->title;
        $newData->slug = $request->slug;
        $newData->content = $request->content;
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
        if (Pages::destroy($id)) {
            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Deleted!'
                ]
            ];

            return redirect(route('admin.pages.index'))->with($alert);
        } else {
            $alert = [
                'alert' => [
                    'status' => 'danger',
                    'message' => __('txt.error_one')
                ]
            ];

            return redirect(route('admin.pages.index'))->with($alert);
        }
    }
}
