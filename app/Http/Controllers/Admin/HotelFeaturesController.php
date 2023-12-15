<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Features;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotelFeaturesController extends Controller
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
        return view('admin.modules.features.index');
    }

    public function indexAjax()
    {
        return datatables()->of(Features::query())->only(
            [
                'id',
                'name',
                'group',
                'filter',
                'updated_at',
                'action',
            ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'filter', 'action'])
            ->addColumn(
                'id', function (Features $data) {
                return ' <div class="checkbox"><input id="selectableItem_' . $data->id . '" type="checkbox" value="' . $data->id . '">
                 <label for="selectableItem_' . $data->id . '">#' . $data->id . '</label>
                 </div>';
            })
            ->addColumn(
                'name', function (Features $data) {
                return $data->name;
            })
            ->addColumn(
                'group', function (Features $data) {
                $group = $data->group()->get()->first();

                return ($group) ? $group->name : '-';
            })
            ->addColumn(
                'filter', function (Features $data) {
                return ($data->filter == 1) ? '<td><span class="badge badge-pill badge-gradient-success">Yes</span></td>' : '<span class="badge badge-pill badge-gradient-danger">No</span>';
            })
            ->addColumn(
                'updated_at', function (Features $data) {
                if (!empty($data->updated_at)) {
                    $updated_at = $data->updated_at->format('d-m-Y H:i:s');
                } else {
                    $updated_at = "";
                }
                return ($updated_at);
            })
            ->addColumn(
                'action', function (Features $data) {
                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="' . route('admin.features.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';
                $action .= '<a href="' . route('admin.features.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                $action .= '</div>';

                return $action;
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('name', $order);
            })
            ->orderColumn('filter', function ($query, $order) {
                $query->orderBy('filter', $order);
            })
            ->orderColumn('group', function ($query, $order) {
                $query->orderBy(function ($query) {
                    $query->select('name')
                        ->from('feature_groups')
                        ->whereColumn('group_id', 'feature_groups.id')
                        ->limit(1);
                }, $order);
            })
            ->toJson();
    }

    public function edit($id)
    {
        $data = Features::findOrFail($id);
        return view('admin.modules.features.edit', compact('data'))->render();
    }

    public function save(Request $request, $id)
    {
        $updateData = Features::findOrFail($id);
        $attributes = [
            'name' => 'Name',
            'group_id' => 'Group',
        ];
        $messages = [];
        $rules = [
            'name' => 'required|min:1|max:191',
            'group_id' => 'required|min:1|max:191',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $updateData->name = $request->name;
        $updateData->filter = $request->filter;
        $updateData->group_id = $request->group_id;
        $save = $updateData->save();
        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => 'Updated!'
            ]
        ];

        return redirect()->back()->with($alert);
    }

    public function remove($id)
    {
        if (Features::destroy($id)) {
            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Deleted!'
                ]
            ];

            return redirect(route('admin.features.index'))->with($alert);
        } else {
            $alert = [
                'alert' => [
                    'status' => 'danger',
                    'message' => __('txt.error_one')
                ]
            ];

            return redirect(route('admin.features.index'))->with($alert);
        }
    }
}
