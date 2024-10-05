<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

use App\UserStatus;
use App\UserType;

class User extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable;
    use \OwenIt\Auditing\Auditable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'picture',
        'bio',
        'type',
        'status',
    ];

    public function getAuditInclude(): array
    {
        return [
            'name',
            'password',
            'username',
            'type',
            'status',
        ];
    }
    public function getAuditExclude(): array
    {
        return [
            'email',
            'picture',
            'bio',
        ];
    }

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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
            'type'=> UserType::class, 
        ];
    }

    public function getPictureAttribute($value){
        return $value ? asset('/images/users/'.$value) : asset('images/users/default-avatar.png');
    }

    public function social_links(){
        return $this->belongsTo(UserSocialLink::class,'id','user_id');
    }
}
