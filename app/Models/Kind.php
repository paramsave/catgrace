<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kind extends Model
{
    use HasFactory;

    protected $table = 'kinds';

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsTo('users', 'kind_id', 'id');
    }
}
