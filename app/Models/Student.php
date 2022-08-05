<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Student extends Model
{
    use HasFactory, HasApiTokens;

    //by default students will be used is not specified.
    protected $table = 'students';

    //timestamp field was removed in migration.
    public $timestamps = false;

    //mass assignment fields
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone'
    ];
}
