<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // for get all product
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the user type in str
     *
     * @return string
     */
    public function getTypeStrAttribute()
    {
        $typeStr = '';

        switch ($this->attributes['type']) {
            case 1: $typeStr = 'Super Admin'; break;
            case 2: $typeStr = 'Admin'; break;
            default: $typeStr = 'Customer';
        }

        return $typeStr;
    }
}
