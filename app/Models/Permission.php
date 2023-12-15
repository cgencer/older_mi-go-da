<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected $table = 'permissions';

    public static function defaultSuperAdminPermissions()
    {
        return [
            'view_newsletter_subscriptions',
            'add_newsletter_subscriptions',
            'edit_newsletter_subscriptions',
            'show_newsletter_subscriptions',
            'save_newsletter_subscriptions',
            'remove_newsletter_subscriptions',

            'view_faqs',
            'add_faqs',
            'edit_faqs',
            'show_faqs',
            'remove_faqs',

            'view_pages',
            'add_pages',
            'edit_pages',
            'show_pages',
            'save_pages',
            'remove_pages',

            'view_contact',
            'add_contact',
            'edit_contact',
            'show_contact',
            'save_contact',
            'remove_contact',

            'view_users',
            'add_users',
            'edit_users',
            'show_users',
            'save_users',
            'remove_users',

            'view_feature_groups',
            'add_feature_groups',
            'edit_feature_groups',
            'show_feature_groups',
            'save_feature_groups',
            'remove_feature_groups',

            'view_features',
            'add_features',
            'edit_features',
            'show_features',
            'save_features',
            'remove_features',

            'view_roles',
            'add_roles',
            'edit_roles',
            'show_roles',
            'save_roles',
            'remove_roles',


            'view_hotels',
            'add_hotels',
            'edit_hotels',
            'show_hotels',
            'save_hotels',
            'remove_hotels',

            'view_users',
            'add_users',
            'edit_users',
            'show_users',
            'save_users',
            'remove_users',

            'view_customers',
            'add_customers',
            'edit_customers',
            'show_customers',
            'save_customers',
            'remove_customers',

            'view_reservations',
            'add_reservations',
            'edit_reservations',
            'show_reservations',
            'save_reservations',
            'remove_reservations',

            'view_payments',
            'add_payments',
            'edit_payments',
            'show_payments',
            'save_payments',
            'remove_payments',

            'view_filemanager',
            'add_filemanager',
            'edit_filemanager',
            'show_filemanager',
            'save_filemanager',
            'remove_filemanager',
        ];
    }
}
