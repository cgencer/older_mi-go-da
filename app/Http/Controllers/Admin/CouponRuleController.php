<?php

namespace App\Http\Controllers\Admin;

use App\Helpers;
use App\Http\Controllers\Controller;
use App\Models\CouponRule;
use App\Models\CouponCode;
use App\Models\CouponUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponRuleController extends Controller
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
        return view('admin.modules.coupon-rules.index');
    }

    public function getCoupons(Request $request)
    {
        if (!empty($request->rule_id)) {
            $coupons = CouponCode::where('rule_id', $request->rule_id)->get();

            if ($coupons->count() > 0) {
                $html = '';
                foreach ($coupons as $coupon) {
                    $status = "primary";
                    $tooltip = 'data-toggle="tooltip" data-placement="right" title="'. trans('txt.Available') .'" data-original-title="'. trans('txt.Available') .'"';
                    if ($coupon->couponUsages) {
                        $status = "warning";
                        $tooltip = 'data-toggle="tooltip" data-placement="right" title="'. trans('txt.desc_used_coupons') .'" data-original-title="'. trans('txt.desc_used_coupons') .'"';
                    }
                    if (!empty($coupon->coupon_usage_id)) {
                        $status = "danger";
                        $tooltip = 'data-toggle="tooltip" data-placement="right" title="'. trans('txt.Unavailable') .'" data-original-title="'. trans('txt.Unavailable') .'"';
                    }
                    $html .= '<li class="m-r-10 m-b-5"><span ' . $tooltip . ' class="badge badge-' . $status . '">' . $coupon->code . '</span></li>';
                }
                echo $html;
            }else {
                echo trans('txt.not_found_coupon');
            }
        }
    }

    public function indexAjax()
    {
        return datatables()->of(CouponRule::query())->only(
            [
                'id',
                'name',
                'is_active',
                'generate',
                'coupons',
                'start_date',
                'end_date',
                'prefix',
                'suffix',
                'length',
                'quantity',
                'created_at',
                'action',
            ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'generate', 'coupons', 'is_active', 'action'])
            ->addColumn(
                'name', function (CouponRule $data) {
                return $data->name;
            })
            ->addColumn(
                'id', function (CouponRule $data) {
                return ' <div class="checkbox"><input id="selectableItem_' . $data->id . '" type="checkbox" value="' . $data->id . '">
                 <label for="selectableItem_' . $data->id . '">#' . $data->id . '</label>
                 </div>';
            })
            ->addColumn(
                'is_active', function (CouponRule $data) {

                return ($data->is_active) ? '<td><span class="badge badge-pill badge-gradient-success">Yes</span></td>' : '<td><span class="badge badge-pill badge-danger">No</span></td>';
            })
            ->addColumn(
                'coupons', function (CouponRule $data) {
                $html = '<a href="#" class="btn btn-info show-coupons" onclick="getCoupons($(this), ' . $data->id . ');" title="Show Coupons"><i class="fa fa-spinner fa-spin" style="display: none;"></i> Show Coupons</a>';
                return $html;
            })
            ->addColumn(
                'generate', function (CouponRule $data) {

                return ($data->generate) ? '<td><span class="badge badge-pill badge-gradient-success">Yes</span></td>' : '<td><span class="badge badge-pill badge-danger">No</span></td>';
            })
            ->addColumn(
                'start_date', function (CouponRule $data) {
                if (!empty($data->start_date)) {
                    $start_date = $data->start_date->format('d-m-Y');
                } else {
                    $start_date = "";
                }
                return ($start_date);
            })
            ->addColumn(
                'end_date', function (CouponRule $data) {
                if (!empty($data->end_date)) {
                    $end_date = $data->end_date->format('d-m-Y');
                } else {
                    $end_date = "";
                }
                return ($end_date);
            })
            ->addColumn(
                'created_at', function (CouponRule $data) {
                if (!empty($data->created_at)) {
                    $created_at = $data->created_at->format('d-m-Y H:i:s');
                } else {
                    $created_at = "";
                }
                return ($created_at);
            })
            ->addColumn(
                'action', function (CouponRule $data) {
                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="' . route('admin.coupon-rules.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';
                $action .= '<a href="' . route('admin.coupon-rules.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                $action .= '</div>';

                return $action;
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('name', $order);
            })
            ->orderColumn('is_active', function ($query, $order) {
                $query->orderBy('is_active', $order);
            })
            ->orderColumn('start_date', function ($query, $order) {
                $query->orderBy('start_date', $order);
            })
            ->orderColumn('end_date', function ($query, $order) {
                $query->orderBy('end_date', $order);
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
            })
            ->toJson();
    }

    public function edit($id)
    {
        $data = CouponRule::findOrFail($id);
        return view('admin.modules.coupon-rules.edit', compact('data'))->render();
    }

    public function save(Request $request, $id)
    {
        $updateData = CouponRule::findOrFail($id);
        $oldData = $updateData->toArray();
        $attributes = [
            'name' => 'Name',
            'is_active' => 'Is Active',
            'generate' => 'Generate',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'prefix' => 'Prefix',
            'suffix' => 'Suffix',
            'length' => 'Length',
            'quantity' => 'Quantity',
        ];
        $messages = [];
        $rules = [
            'name' => 'required|min:1|max:255',
            'is_active' => 'required|min:1|max:4',
            'prefix' => 'required|min:1|max:255',
            'suffix' => 'required|min:1|max:255',
            'length' => 'required|min:1|max:6',
            'quantity' => 'required|min:1|max:6',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $updateData->name = $request->name;
        $updateData->is_active = $request->is_active;
        if ($oldData['generate'] != 1 && $request->generate == 1) {
            $updateData->generate = $request->generate;
        }
        $updateData->start_date = $request->start_date;
        $updateData->end_date = $request->end_date;
        $updateData->prefix = $request->prefix;
        $updateData->suffix = $request->suffix;
        $updateData->length = $request->length;
        $updateData->quantity = $request->quantity;
        $save = $updateData->save();

        if ($save) {
            if ($updateData->generate == "1" && $oldData['generate'] != 1) {
                for ($i = 0; $i < $updateData->quantity; $i++) {
                    $newCoupon = new \App\Models\CouponCode();
                    $newCoupon->rule_id = $updateData->id;
                    $newCoupon->code = Helpers::getAvailableCouponCode($updateData->prefix, $updateData->suffix, $updateData->length);
                    $newCoupon->save();
                }
            }
        }

        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => ($updateData->generate == 1 && $oldData['generate'] == 0) ? 'Updated and Coupons Generated!' : 'Updated!'
            ]
        ];

        return redirect()->back()->with($alert);
    }

    public function add(Request $request)
    {
        if (!isset($request->submitted) || empty($request->submitted)) {
            return view('admin.modules.coupon-rules.add')->render();
        }
        $newData = new CouponRule();
        $attributes = [
            'name' => 'Name',
            'is_active' => 'Is Active',
            'generate' => 'Generate',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'prefix' => 'Prefix',
            'suffix' => 'Suffix',
            'length' => 'Length',
            'quantity' => 'Quantity',
        ];
        $messages = [];
        $rules = [
            'name' => 'required|min:1|max:255',
            'is_active' => 'required|min:1|max:4',
            'prefix' => 'required|min:1|max:255',
            'suffix' => 'required|min:1|max:255',
            'length' => 'required|min:1|max:6',
            'quantity' => 'required|min:1|max:6',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $newData->name = $request->name;
        $newData->is_active = $request->is_active;
        $newData->generate = (empty($request->generate)) ? 0 : 1;
        $newData->start_date = $request->start_date;
        $newData->end_date = $request->end_date;
        $newData->prefix = $request->prefix;
        $newData->suffix = $request->suffix;
        $newData->length = $request->length;
        $newData->quantity = $request->quantity;
        $save = $newData->save();

        if ($save) {
            if ($newData->generate == 1) {
                for ($i = 0; $i < $newData->quantity; $i++) {
                    $newCoupon = new \App\Models\CouponCode();
                    $newCoupon->rule_id = $newData->id;
                    $newCoupon->code = Helpers::getAvailableCouponCode($newData->prefix, $newData->suffix, $newData->length);
                    $newCoupon->save();
                }
            }
        }

        $alert = [
            'alert' => [
                'status' => 'success',
                'message' => ($newData->generate == 1) ? 'Added and Coupons Generated!' : 'Added!'
            ]
        ];

        return redirect()->back()->with($alert);
    }

    public function remove($id)
    {
        //check coupon usage
        $couponUsage = CouponUsage::where('rule_id', $id)->get();
            if ($couponUsage->count() > 0) {
                $alert = [
                    'alert' => [
                        'status' => 'danger',
                        'message' => __('txt.abort_coupon_delete')
                    ]
                ];
                return redirect(route('admin.coupon-rules.index'))->with($alert);
            }else{
                CouponCode::where('rule_id', $id)->delete();
                    if (CouponRule::destroy($id)) {
                        $alert = [
                            'alert' => [
                                'status' => 'success',
                                'message' => 'Deleted!'
                            ]
                        ];


                    return redirect(route('admin.coupon-rules.index'))->with($alert);
                } else {
                    $alert = [
                        'alert' => [
                            'status' => 'danger',
                            'message' => __('txt.error_one')
                        ]
                    ];

                        return redirect(route('admin.coupon-rules.index'))->with($alert);
                    }
            }
        }
}
