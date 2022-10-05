<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExperienceUser extends Model
{
    // use HasFactory;

    use SoftDeletes;

    public $table = 'experience_users';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_detail_id',
        'experience',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // one to many

    public function detail_user()
    {
        return $this->belongsTo('App\Models\DetailUser', 'user_detail_id', 'id');
    }
}
