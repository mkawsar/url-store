<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    public function domain(): object
    {
        return $this->hasOne(Domain::class, 'id', 'domain_id');
    }
}
