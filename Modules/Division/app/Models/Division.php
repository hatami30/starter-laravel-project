<?php

namespace Modules\Division\Models;

use Modules\User\Models\User;
use Modules\Division\Database\Factories\DivisionFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    protected static function newFactory(): DivisionFactory
    {
        return DivisionFactory::new();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getFormattedNameAttribute()
    {
        return strtoupper($this->name);
    }
}
