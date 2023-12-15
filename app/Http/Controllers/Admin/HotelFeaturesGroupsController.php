<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureCategories;
use App\Models\FeatureGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotelFeaturesGroupsController extends Controller
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
        return view('admin.modules.feature_groups.index');
    }

    public function indexAjax()
    {
        return datatables()->of(FeatureGroups::query())->only(
            [
                'id',
                'name',
                'filter',
                'position',
                'admin_position',
                'category',
                'updated_at',
                'action',
            ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'filter', 'action'])
            ->addColumn(
                'id', function (FeatureGroups $data) {
                return ' <div class="checkbox"><input id="selectableItem_' . $data->id . '" type="checkbox" value="' . $data->id . '">
                 <label for="selectableItem_' . $data->id . '">#' . $data->id . '</label>
                 </div>';
            })
            ->addColumn(
                'name', function (FeatureGroups $data) {
                return $data->name;
            })
            ->addColumn(
                'position', function (FeatureGroups $data) {
                return $data->position;
            })
            ->addColumn(
                'filter', function (FeatureGroups $data) {

                return ($data->filter == 1) ? '<td><span class="badge badge-pill badge-gradient-success">Yes</span></td>' : '<span class="badge badge-pill badge-gradient-danger">No</span>';
            })
            ->addColumn(
                'category', function (FeatureGroups $data) {
                $category = $data->category()->get();
                if ($category->count() > 0) {
                    $category = $category->first();
                    return $category->name;;
                } else {
                    return '-';
                }

            })
            ->addColumn(
                'updated_at', function (FeatureGroups $data) {
                if (!empty($data->updated_at)) {
                    $updated_at = $data->updated_at->format('d-m-Y H:i:s');
                } else {
                    $updated_at = "";
                }
                return ($updated_at);
            })
            ->addColumn(
                'action', function (FeatureGroups $data) {
                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="' . route('admin.feature_groups.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';
                $action .= '<a href="' . route('admin.feature_groups.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                $action .= '</div>';

                return $action;
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('name', $order);
            })
            ->orderColumn('position', function ($query, $order) {
                $query->orderBy('position', $order);
            })
            ->orderColumn('admin_position', function ($query, $order) {
                $query->orderBy('admin_position', $order);
            })
            ->orderColumn('filter', function ($query, $order) {
                $query->orderBy('filter', $order);
            })
            ->orderColumn('updated_at', function ($query, $order) {
                $query->orderBy('updated_at', $order);
            })
            ->orderColumn('category', function ($query, $order) {
                $query->orderBy(function ($query) {
                    $query->select('name')
                        ->from('feature_categories')
                        ->whereColumn('category_id', 'feature_categories.id')
                        ->limit(1);
                }, $order);
            })
            ->toJson();
    }

    public function edit($id)
    {
        $data = FeatureGroups::findOrFail($id);
        return view('admin.modules.feature_groups.edit', compact('data'))->render();
    }

    public function save(Request $request, $id)
    {
        $updateData = FeatureGroups::findOrFail($id);
        $attributes = [
            'name' => 'Name',
            'category_id' => 'Category',
            'filter' => 'Filter',
            'position' => 'Position',
        ];
        $messages = [];
        $rules = [
            'name' => 'required|min:1|max:191',
            'category_id' => 'required|min:1|max:191',
            'filter' => 'required|min:1|max:191',
            'position' => ($request->filter) ? 'required|numeric' : '',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $updateData->name = $request->name;
        $updateData->category_id = $request->category_id;
        $updateData->filter = $request->filter;
        $updateData->position = $request->position;
        $updateData->admin_position = $request->admin_position;
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
        if (FeatureGroups::destroy($id)) {
            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Deleted!'
                ]
            ];

            return redirect(route('admin.feature_groups.index'))->with($alert);
        } else {
            $alert = [
                'alert' => [
                    'status' => 'danger',
                    'message' => __('txt.error_one')
                ]
            ];

            return redirect(route('admin.feature_groups.index'))->with($alert);
        }
    }
}
