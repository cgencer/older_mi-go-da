<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\contactForms;
use App\Models\Customers;

class ContactFormController extends Controller
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
        return view('admin.modules.contact.index');
    }

    public function indexAjax()
    {
        return datatables()->of(contactForms::query())->only(
            [
                'id',
                'user',
                'subject',
                'created_at',
                'action',
            ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'user', 'action'])
            ->addColumn(
                'user', function (contactForms $data) {
                return '<div class="list-media">
                        <div class="list-item">
                            <div class="info p-l-0">
                                <span class="title">Fullname: ' . $data->fullname . '</span>
                                <span class="sub-title">Phone: ' . $data->phone . '</span>
                                <span class="sub-title">Email: ' . $data->email . '</span>
                            </div>
                        </div>
                    </div>';
            })
            ->addColumn(
                'id', function (contactForms $data) {
                return ' <div class="checkbox"><input id="selectableItem_' . $data->id . '" type="checkbox" value="' . $data->id . '">
                 <label for="selectableItem_' . $data->id . '">#' . $data->id . '</label>
                 </div>';
            })
            ->addColumn(
                'created_at', function (contactForms $data) {
                if (!empty($data->created_at)) {
                    $created_at = $data->created_at->format('d-m-Y H:i:s');
                } else {
                    $created_at = "";
                }
                return ($created_at);
            })
            ->addColumn(
                'action', function (contactForms $data) {
                $action = '<div class="text-center font-size-16 btn-group">';
                $action .= '<a href="' . route('admin.contact.show', $data->id) . '" class="btn btn-success" title="Show"><i class="ti-eye"></i></a>';
                $action .= '<a href="' . route('admin.contact.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
                $action .= '</div>';

                return $action;
            })->toJson();
    }

    public function show($id)
    {
        $data = contactForms::findOrFail($id);

        return view('admin.modules.contact.show', compact('data'))->render();
    }

    public function remove($id)
    {
        if (contactForms::destroy($id)) {
            $alert = [
                'alert' => [
                    'status' => 'success',
                    'message' => 'Deleted!'
                ]
            ];

            return redirect(route('admin.contact.index'))->with($alert);
        } else {
            $alert = [
                'alert' => [
                    'status' => 'danger',
                    'message' => __('txt.error_one')
                ]
            ];

            return redirect(route('admin.contact.index'))->with($alert);
        }
    }
}
