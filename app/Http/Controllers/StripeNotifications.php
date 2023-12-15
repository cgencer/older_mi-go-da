<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class StripeNotifications extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function receiveHook(Request $request)
    {
		if ($request->isMethod('post')) {
			$r = $request->all();
			echo('Product ' . $r['data']['object']['name'] . ': ' . $r['data']['object']['description'] . ' created.');
		}
//    	echo(join(', ', array_keys((array) $request->query->parameters)));
//    	echo('Product' . $request->data->object->name . ': ' . $request->data->object->description . ' created.');
	}
}
