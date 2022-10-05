<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThumbnailService extends Model
{
    // use HasFactory;
    use SoftDeletes;

    public $table = 'thumbnail_services';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'service_id',
        'thumbnail',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
