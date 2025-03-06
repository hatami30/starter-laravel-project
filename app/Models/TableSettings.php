<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;

class TableSettings extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
