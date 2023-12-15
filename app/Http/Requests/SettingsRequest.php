<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'terms' => 'required',
            'data_protection' => 'required',
            'imprint' => 'required',
            'jff_admin_email' => 'required|email',
            'jff_coupon_rule' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'terms' => 'Terms and Conditions',
            'data_protection' => 'Data Protection',
            'imprint' => 'Imprint',
            'cookie_information' => 'Cookie Information',
            'cookie_policy' => 'Cookie Policy',
            'jff_admin_email' => 'Admin Email',
            'jff_coupon_rule' => 'Coupon Rules',
        ];
    }
}
