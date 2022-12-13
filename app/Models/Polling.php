<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polling extends Model
{
    use HasFactory;

    public $keyType = 'string';

    protected $guarded = [];

    public function Choises()
    {
        return $this->hasMany(Choises::class, 'polling_id');
    }
}
