<?php

namespace Modules\Division\Models;

use Carbon\Carbon;
// use Modules\User\Models\User;
use App\Models\TableSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\DocumentManagement\Models\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yogameleniawan\SearchSortEloquent\Traits\Sortable;
use Modules\Division\Database\Factories\DivisionFactory;
use Yogameleniawan\SearchSortEloquent\Traits\Searchable;

class Division extends Model
{
    use HasFactory, Notifiable, Searchable, Sortable, SoftDeletes;

    // protected $fillable = [
    //     'name',
    //     'description',
    // ];

    protected static function newFactory(): DivisionFactory
    {
        return DivisionFactory::new();
    }

    protected $guarded = ['id'];

    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
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

    public function getFormattedNameAttribute()
    {
        return strtoupper($this->name);
    }

    // Kolom yang bisa dicari
    // public function searchable(): array
    // {
    //     return [
    //         'name',
    //         'description', // Nama dan deskripsi dapat dicari
    //     ];
    // }

    // // Kolom yang bisa diurutkan
    // public function sortable(): array
    // {
    //     return [
    //         'name',
    //         'description',
    //         'created_at',
    //         'updated_at',
    //         'deleted_at', // Kolom yang dapat diurutkan
    //     ];
    // }
}
