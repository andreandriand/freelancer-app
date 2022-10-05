<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailUser extends Model
{
    // use HasFactory;
    use SoftDeletes;

    public $table = 'detail_users';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'photo',
        'role',
        'contact',
        'biography',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // one to one

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    // one to many

    public function experience_user()
    {
        return $this->hasMany('App\Models\ExperienceUser', 'user_detail_id');
    }
}
