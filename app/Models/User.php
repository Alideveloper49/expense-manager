<?php

namespace App\Models;

use App\Notifications\ResetPassword;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use SoftDeletes, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime:' . config('panel.date_format') . ' ' . config('panel.time_format'),
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
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

    /**
     * Get the expense categories created by this user.
     */
    public function expenseCategories(): HasMany
    {
        return $this->hasMany(ExpenseCategory::class, 'created_by_id');
    }

    /**
     * Get the income categories created by this user.
     */
    public function incomeCategories(): HasMany
    {
        return $this->hasMany(IncomeCategory::class, 'created_by_id');
    }

    /**
     * Get the expenses created by this user.
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'created_by_id');
    }

    /**
     * Get the incomes created by this user.
     */
    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class, 'created_by_id');
    }

    /**
     * Set the password attribute, hashing it if necessary.
     */
    public function setPasswordAttribute($input): void
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Get the roles assigned to this user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
    /**
     * Boot the model and register event listeners.
     */
    protected static function booted(): void
    {
        static::created(function (User $user) {
            $registrationRole = config('panel.registration_default_role');

            if (!$user->roles()->get()->contains($registrationRole)) {
                $user->roles()->attach($registrationRole);
            }
        });
    }
}
