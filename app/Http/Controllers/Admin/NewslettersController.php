<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\contactForms;
use App\Models\newsletterSubscriptions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NewslettersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'role:SuperAdmin'])->only(
            [
                'remove',
            ]);
    }

    public function index()
    {
        return view('admin.modules.newsletter_subscriptions.index');
    }

    public function indexAjax()
    {
        return datatables()->of(newsletterSubscriptions::query())->only(
            [
                'id',
                'user',
                'created_at',
                'action',
            ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'user', 'action'])
            ->addColumn(
                'user', function (newsletterSubscriptions $data) {
                return '<div class="list-media">
                        <div class="list-item">
                            <div class="info p-l-0">
                                <span class="title">Fullname: ' . $data->fullname . '</span>
                                <span class="sub-title">Email: ' . $data->email . '</span>
                            </div>
                        </div>
                    </div>';
            })
            ->addColumn(
                'id', function (newsletterSubscriptions $data) {
                return ' <div class="checkbox"><input id="selectableItem_' . $data->id . '" type="checkbox" value="' . $data->id . '">
                 <label for="selectableItem_' . $data->id . '">#' . $data->id . '</label>
                 </div>';
            })
            ->addColumn(
                'created_at', function (newsletterSubscriptions $data) {
                if (!empty($data->created_at)) {
                    $created_at = $data->created_at->format('d-m-Y H:i:s');;
                } else {
                    $created_at = "";
                }
                return ($created_at);
            })
            ->addColumn(
                'action', function (newsletterSubscriptions $data) {
                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="' . route('admin.newsletter_subscriptions.show', $data->id) . '" class="btn btn-success" title="Show"><i class="ti-eye"></i></a>';
                $action .= '<a href="' . route('admin.newsletter_subscriptions.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                $action .= '</div>';

                return $action;
            })->toJson();
    }

    public function show($id)
    {
        $data = newsletterSubscriptions::findOrFail($id);

        return view('admin.modules.newsletter_subscriptions.show', compact('data'))->render();
    }

    public function remove($id)
    {
        if (newsletterSubscriptions::destroy($id)) {
            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Deleted!'
                ]
            ];

            return redirect(route('admin.newsletter_subscriptions.index'))->with($alert);
        } else {
            $alert = [
                'alert' => [
                    'status' => 'danger',
                    'message' => __('txt.error_one')
                ]
            ];

            return redirect(route('admin.newsletter_subscriptions.index'))->with($alert);
        }
    }
}
