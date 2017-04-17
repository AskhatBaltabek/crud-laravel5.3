<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends BaseModel
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public static $inputs = [
        'name' => ['type' => 'text', 'required' => true],
        'email' => ['type' => 'text', 'required' => true],
        'admin' => ['type' => 'number'],
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }
}
