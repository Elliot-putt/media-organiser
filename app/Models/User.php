<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use phpDocumentor\Reflection\Types\False_;

class User extends Authenticatable {

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
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

    public function generateUsername(): string
    {
        return $this->name[0] . Carbon::now()->format('d') . $this->name[0] . $this->id;
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_users');
    }

    public function companiesArray()
    {
        return auth()->user()->companies()->pluck('company_id')->toArray();
    }

    public function hasCompany($id)
    {
        $array = $this->companies()->pluck('company_id')->toArray();
        if(in_array($id, $array))
        {
            return false;
        } else
        {
            return true;
        }
    }

    public function scopeUsernameFilter($query, $username)
    {
        return $query->where('username', 'LIKE', '%' . $username . '%');
    }
    //////////////////////////////////////////////
    //////// User Password generator ////////////
    /////////////////////////////////////////////
    public function random_password($length): string
    {
        //A list of characters that can be used in our
        //random password.
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!-.[]?*()';
        //Create a blank string.
        $password = '';
        //Get the index of the last character in our $characters string.
        $characterListLength = mb_strlen($characters, '8bit') - 1;
        //Loop from 1 to the $length that was specified.
        foreach(range(1, $length) as $i)
        {
            $password .= $characters[random_int(0, $characterListLength)];
        }

        return $password;
    }

}
