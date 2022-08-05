<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    use HasFactory;

    //by default projects will be used is not specified.
    protected $table = 'projects';

    //timestamp field was removed in migration.
    public $timestamps = false;

    //mass assignment fields
    protected $fillable = [
        'name',
        'student_id',
        'description',
        'duration'
    ];
}
