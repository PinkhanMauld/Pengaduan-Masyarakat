<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    use HasFactory;
    protected $fillable = [
        'description', 'voting', 'type', 'province', 'subdistrict', 'regency', 'village', 'viewers', 'image', 'statement', 'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'id', 'report_id');
    }

    public function response()
    {
        return $this->hasOne(Response::class);
    }
}


