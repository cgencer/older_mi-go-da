<?php

use App\Models\Countries;
use App\Models\Hotels;

/*it('Check Hotels Datatable for Admin', function () {
    $query = Hotels::query();
    $datatable = datatables()->of($query)->only(
        [
            'id',
            'hotel',
            'user',
            'address',
            'country_id',
            'created_at',
            'updated_at',
            'action',
        ])->startsWithSearch()->escapeColumns()->rawColumns(['id', 'hotel', 'user', 'action'])
        ->addColumn(
            'hotel', function (Hotels $data) {
            return '<div class="list-media">
                            <div class="list-item">
                                <div class="info p-l-0">
                                    <span class="title">' . $data->name . '</span>
                                    <span class="sub-title">Star: ' . $data->getStar() . '</span>
                                </div>
                            </div>
                        </div>';
        })
        ->addColumn(
            'user', function (Hotels $data) {
            if ($data->user_id) {
                $user = $data->hotel_user()->get()->first();
                $profile_image = $user->getMedia('profile_image')->first();

                return '<div class="list-media">
                            <div class="list-item">
                                <div class="media-img">
                                    <a href="' . (route('admin.users.edit', ['id' => $user->id])) . '">
                                        <img src="' . ($profile_image ? $profile_image->getUrl() : asset('admin/assets/images/avatars/default_avatar.png')) . '">
                                    </a>
                                </div>
                                <div class="info">
                                    <span class="title"><a href="' . (route('admin.users.edit', ['id' => $user->id])) . '">' . ((empty($user->firstname) || empty($user->lastname)) ? $user->username : ($user->firstname . ' ' . $user->lastname)) . '</a></span>
                                    <span class="sub-title">ID: ' . $user->id . '</span>
                                    <span class="sub-title">Username: ' . ($user->username) . '</span>
                                </div>
                            </div>
                        </div>';
            } else {
                return '<div class="list-media">
                            <div class="list-item">
                                <div class="info p-l-0">
                                    <span class="title">No User.</span>
                                </div>
                            </div>
                        </div>';
            }
        })
        ->addColumn(
            'id', function (Hotels $data) {
            return ' <div class="checkbox"><input id="selectableItem_' . $data->id . '" type="checkbox" value="' . $data->id . '">
                     <label for="selectableItem_' . $data->id . '">#' . $data->id . '</label>
                     </div>';
        })
        ->addColumn(
            'country_id', function (Hotels $data) {
            $country = Countries::where('id', $data->country_id)->get()->first();

            return $country->name;
        })
        ->addColumn(
            'created_at', function (Hotels $data) {
            if (!empty($data->created_at)) {
                $created_at = $data->created_at->toDateTimeString();
            } else {
                $created_at = "";
            }
            return ($created_at);
        })
        ->addColumn(
            'updated_at', function (Hotels $data) {
            if (!empty($data->updated_at)) {
                $updated_at = $data->updated_at->toDateTimeString();
            } else {
                $updated_at = "";
            }
            return ($updated_at);
        })
        ->addColumn(
            'action', function (Hotels $data) {
            $action = '<div class="text-center font-size-16 btn-group">';
            $action .= '<a href="' . route('f.detail', ['id' => $data->id, 'slug' => $data->slug]) . '" class="btn btn-info" title="Show" target="_blank"><i class="ti-eye"></i></a>';
            $action .= '<a href="' . route('admin.hotels.edit', $data->id) . '" class="btn btn-success" title="Edit"><i class="ti-pencil"></i></a>';
            $action .= '<a href="' . route('admin.hotels.remove', $data->id) . '" onclick="return confirm(\'Are you sure you want to delete it?\');" class="btn btn-danger" title="Remove"><i class="ti-trash"></i></a>';
            $action .= '</div>';

            return $action;
        })
        ->orderColumn('user', function ($query, $order) {
            $query->orderBy(function ($query) {
                $query->select('username')
                    ->from('users')
                    ->whereColumn('user_id', 'users.id')
                    ->limit(1);
            }, $order);
        })
        ->orderColumn('hotel', function ($query, $order) {
            $query->orderBy('name', $order);
        })
        ->orderColumn('id', function ($query, $order) {
            $query->orderBy('id', $order);
        })
        ->orderColumn('created_at', function ($query, $order) {
            $query->orderBy('created_at', $order);
        })
        ->orderColumn('country_id', function ($query, $order) {
            $query->orderBy(function ($query) {
                $query->select('name')
                    ->from('countries')
                    ->whereColumn('country_id', 'countries.id')
                    ->limit(1);
            }, $order);
        })
        ->orderColumn('updated_at', function ($query, $order) {
            $query->orderBy('created_at', $order);
        })
        ->toJson();
    if (isset($datatable->original['error'])) {
        $this->assertFalse($datatable->original['error'], $datatable->original['error_message'], 'Tablo hata verdi.');
    } else {
        $this->assertEquals([200, $datatable->original['recordsTotal']], [$datatable->status(), Hotels::all()->count()], 'Tablodan doğru sonuç gelmedi.');
    }
})->group('admin-datatable');*/
