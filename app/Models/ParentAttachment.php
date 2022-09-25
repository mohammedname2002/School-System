<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentAttachment extends Model
{
    use HasFactory;


     public $File_Name = '';

    protected $fillable = ['Parent_id' , 'File_Name' ];

}
