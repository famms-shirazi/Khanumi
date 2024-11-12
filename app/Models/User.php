<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table  = "users_tbl";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['first_name', 'last_name', 'phone_number', 'email', 'national_code', 'gender', 'birthday_date','password','username'];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    public function findForAuth($username){
        if(filter_var($username,FILTER_VALIDATE_EMAIL)) return $this->where('email', $username)->first();
            else if(preg_match('/^09\d{9}$/', $username)) return $this->where('username', $username)->first();
            else return $this->where('phone_number', $username)->first();
    }
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }
    public function shoppingCarts(): HasMany
    {
        return $this->HasMany(ShoppingCart::class);
    }

    public function orders(): HasMany
    {
        return $this->HasMany(Order::class);
    }

    public function addresses(): HasMany
    {
        return $this->HasMany(Address::class);
    }

}
