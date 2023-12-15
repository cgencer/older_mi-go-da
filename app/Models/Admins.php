<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Plank\Mediable\Mediable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Revolution\Google\Sheets\Traits\GoogleSheets;
use \Venturecraft\Revisionable\RevisionableTrait;

class Admins extends Authenticatable
{
    use HasRoles, Notifiable, GoogleSheets, Mediable, RevisionableTrait;

    protected $table = 'admins';
    protected $revisionCleanup = true;
    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;
    protected $keepRevisionOf = ['username', 'email', 'phone', 'password'];
    protected $dontKeepRevisionOf = ['created_at', 'updated_at', 'deleted_at', 'remember_token'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'access_token',
        'refresh_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'last_login',
        'created_at',
        'updated_at',
    ];

    protected function sheetsAccessToken()
    {
        return [
            'access_token' => $this->access_token,
            'refresh_token' => $this->refresh_token,
            'expires_in' => 3600,
            'created' => $this->updated_at->getTimestamp(),
        ];
    }
}
