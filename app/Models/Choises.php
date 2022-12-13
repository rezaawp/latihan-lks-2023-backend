<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choises extends Model
{
    use HasFactory;

    public $keyType = 'string';

    protected $guarded = [];

    public function Vote()
    {
        return $this->hasOne(Vote::class, 'choise_id');
    }
}
