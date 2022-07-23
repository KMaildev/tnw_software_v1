<?php

namespace App\Models\Models;

use App\Models\Township;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;


    public function township_table()
    {
        return $this->belongsTo(Township::class, 'township_id', 'id');
    }
}
