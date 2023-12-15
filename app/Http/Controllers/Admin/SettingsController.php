<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsRequest;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'role:SuperAdmin'])->only(
            [
                'edit',
                'remove',
            ]);
    }

    public function index()
    {
        // Pages
        $pages = collect(\App\Models\Pages::all()->pluck('title', 'id')->toArray());
        $pages->put('', "Select Page");

        $selectedPages = array();
        $selectedPages['terms'] = settings()->get('terms');
        $selectedPages['data_protection'] = settings()->get('data_protection');
        $selectedPages['imprint'] = settings()->get('imprint');
        $selectedPages['cookie_policy'] = settings()->get('cookie_policy');

        // Join For Free Settings
        $jffSettings = array();
        $couponRules = \App\Models\CouponRule::all()->pluck('name', 'id')->toArray();
        $pages->put('', "Select Coupon Rule");

        $jffSettings['jff_admin_email'] = settings()->get('jff_admin_email');
        $jffSettings['jff_coupon_rule'] = settings()->get('jff_coupon_rule');

        return view('admin.modules.settings.edit', compact('selectedPages', 'pages', 'couponRules', 'jffSettings'))->render();
    }

    public function save(SettingsRequest $r)
    {
        $validator = $r->validated();
        try {
            //Pages settings..
            if ($r->terms) {
                settings()->set('terms', $r->terms);
            }
            if ($r->data_protection) {
                settings()->set('data_protection', $r->data_protection);
            }
            if ($r->imprint) {
                settings()->set('imprint', $r->imprint);
            }
            if ($r->cookie_policy) {
                settings()->set('cookie_policy', $r->cookie_policy);
            }

            // Join For Free Settings
            if ($r->jff_admin_email) {
                settings()->set('jff_admin_email', $r->jff_admin_email);
            }
            if ($r->jff_coupon_rule) {
                settings()->set('jff_coupon_rule', $r->jff_coupon_rule);
            }
            settings()->save();

            return redirect()->back()->with('success', 'Site settings have been updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Could not be updated.');
        }
    }

}
