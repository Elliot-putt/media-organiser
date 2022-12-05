<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use phpDocumentor\Reflection\Types\False_;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia {

    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

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

    //Spatie Media library allows file uploads
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('file');
    }

    public function photos()
    {
        return $this->getMedia('file');
    }

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

    public static function moveKeyBefore($arr, $find, $move)
    {
        if(! isset($arr[$find], $arr[$move]))
        {
            return $arr;
        }

        $elem = [$move => $arr[$move]];  // cache the element to be moved
        $start = array_splice($arr, 0, array_search($find, array_keys($arr)));
        unset($start[$move]);  // only important if $move is in $start

        return $start + $elem + $arr;
    }

    public static function moveElement(&$array, $a, $b)
    {
        $p1 = array_splice($array, $a, 1);
        $p2 = array_splice($array, 0, $b);
        $array = array_merge($p2, $p1, $array);
    }

}
