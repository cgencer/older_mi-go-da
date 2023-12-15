<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Notifications\Notifiable;
use Plank\Mediable\Mediable;
use Spatie\Permission\Traits\HasRoles;
use ChristianKuri\LaravelFavorite\Traits\Favoriteability;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Hash;
use \Venturecraft\Revisionable\RevisionableTrait;

class User extends Model implements Authenticatable
{
    use AuthenticableTrait, Notifiable, HasRoles, Uuids, Mediable, RevisionableTrait;

    protected $table = 'users';
    protected $appends = ['stripeAccountId'];
    protected $stripe_tags = ['account_sid'];
    protected $revisionCleanup = true;
    protected $revisionCreationsEnabled = true;
    protected $revisionForceDeleteEnabled = true;
    protected $keepRevisionOf = ['username', 'email', 'phone', 'password'];
    protected $dontKeepRevisionOf = ['created_at', 'updated_at', 'deleted_at', 'remember_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'last_login' => 'datetime',
        'email_verified_at' => 'datetime',
        'stripe_data' => 'array'
    ];

    public function hotels()
    {
        return $this->hasMany('App\Models\Hotels', 'user_id', 'id');
    }

    public function documents()
    {
        return $this->hasManyThrough('App\Models\Documents', 'userID');
    }

    public function hotel_reservations()
    {
        return $this->hasManyThrough('App\Models\Reservation', 'App\Models\Hotels', 'user_id', 'hotel_id', 'id', 'id')->select('reservations.*');
    }

    public function setPassword($password)
    {
        $this->password = Hash::make($password);
        return $this->save();
    }

    public function getStatusText()
    {
        return ($this->enabled) ? '<span class="badge badge-xl badge-success">Active</span>' : '<span class="badge badge-xl badge-warning">Not Active</span>';
    }

    public function getStripeAccountIdAttribute()
    {
        return $this->stripe_data['account_sid'] ?? false; 
    }

    public function setStripeAccountIdAttribute($id)
    {
        $this->saveStripeData(['account_sid' => $id]);
    }

    public function saveStripeData($in)
    {
        $this->stripe_data = array_merge($this->stripe_data ?? [], $in);
        $this->save();
    }

}
