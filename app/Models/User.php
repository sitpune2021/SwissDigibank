<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Address;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'fname',
        'lname',
        'role_id',
        'email',
        'password',
        'mobile',
        'designation',
        'username',
        'branch_id',
        'login_on_holidays',
        'searchable_accounts',
        'user_active',
        'back_edate_days',
        'emp_id',
        'otp',
        'otp_expires_at'
    ];
    protected $casts = [
        'otp_expires_at' => 'datetime',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function employees()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branche_id');
    }
    public function companyCertificates()
    {
        return $this->hasOne(CompanyCertificate::class);
    }
    public function member()
    {
        return $this->hasOne(Member::class, 'user_id', 'id');
    }
    public function addresses()
    {
        return $this->hasMany(Address::class, 'member_id', 'id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    /* ================= Permission Logic ================= */
    public function isSuperAdmin(): bool
    {
        return (int) $this->role_id === 1;
    }
    //  public function isSuperAdmin(): bool
    // {
    //     return optional($this->role)->name === 'Super Admin';
    // }
}
