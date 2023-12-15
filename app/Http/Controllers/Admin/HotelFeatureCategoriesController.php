<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HotelFeatureCategoriesController extends Controller
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
        return view('admin.modules.feature_categories.index');
    }

    public function indexAjax()
    {
        return datatables()->of(FeatureCategories::query())->only(
            [
                'id',
                'icon',
                'name',
                'updated_at',
                'action',
            ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'icon', 'action'])
            ->addColumn(
                'id', function (FeatureCategories $data) {
                return ' <div class="checkbox"><input id="selectableItem_' . $data->id . '" type="checkbox" value="' . $data->id . '">
                 <label for="selectableItem_' . $data->id . '">#' . $data->id . '</label>
                 </div>';
            })
            ->addColumn(
                'name', function (FeatureCategories $data) {
                return $data->name;
            })
            ->addColumn(
                'updated_at', function (FeatureCategories $data) {
                if (!empty($data->updated_at)) {
                    $updated_at = $data->updated_at->format('d-m-Y H:i:s');
                } else {
                    $updated_at = "";
                }
                return ($updated_at);
            })
            ->addColumn(
                'action', function (FeatureCategories $data) {
                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="' . route('admin.feature_categories.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';
                $action .= '<a href="' . route('admin.feature_categories.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                $action .= '</div>';

                return $action;
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('name', $order);
            })
            ->orderColumn('updated_at', function ($query, $order) {
                $query->orderBy('updated_at', $order);
            })
            ->toJson();
    }

    public function edit($id)
    {
        $data = FeatureCategories::findOrFail($id);
        return view('admin.modules.feature_categories.edit', compact('data'))->render();
    }

    public function save(Request $request, $id)
    {
        $updateData = FeatureCategories::findOrFail($id);
        $attributes = [
            'name' => 'Name',
            'icon' => 'Icon',
        ];
        $messages = [];
        $rules = [
            'name' => 'required|min:1|max:191',
//            'icon' => 'required|min:1|max:191',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $updateData->name = $request->name;
        if (!empty($request->icon)) {
            $updateData->icon = $request->icon;
        }
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
        if (FeatureCategories::destroy($id)) {
            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Deleted!'
                ]
            ];

            return redirect(route('admin.feature_categories.index'))->with($alert);
        } else {
            $alert = [
                'alert' => [
                    'status' => 'danger',
                    'message' => __('txt.error_one')
                ]
            ];

            return redirect(route('admin.feature_categories.index'))->with($alert);
        }
    }
}
