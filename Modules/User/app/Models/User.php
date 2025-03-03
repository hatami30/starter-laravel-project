<?php

namespace Modules\User\Models;

use App\Models\TableSettings;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Laravel\Sanctum\HasApiTokens;
use Modules\Division\Models\Division;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Modules\User\Database\Factories\UserFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Yogameleniawan\SearchSortEloquent\Traits\Searchable;
use Yogameleniawan\SearchSortEloquent\Traits\Sortable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, Searchable, Sortable, SoftDeletes;

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F d, Y h:i A');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F d, Y h:i A');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F d, Y h:i A');
    }

    public function getDeletedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F d, Y h:i A');
    }

    public function tableSettings()
    {
        return $this->hasOne(TableSettings::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // public function hasRole(string $role): bool
    // {
    //     return $this->roles->contains('name', $role);
    // }

    // public function hasPermission(string $permission): bool
    // {
    //     return $this->hasPermissionTo($permission);
    // }

    // public function createApiToken(array $abilities = ['*'])
    // {
    //     return $this->createToken('API Token', $abilities)->plainTextToken;
    // }
}
