<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function scopePhone($query, $phone)
    {
        return $query->where('phone', $phone);
    }

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] =  Carbon::parse($value);
    }
}
