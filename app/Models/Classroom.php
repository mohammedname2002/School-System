<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grade;

use Spatie\Translatable\HasTranslations;

class Classroom extends Model
{
    use HasFactory;

    use HasTranslations;
public $timestamps = true;
    public $translatable = ['Name'];
    protected $fillable = ['Name' , 'Grade_id'];

    public function Grades(){

        return   $this->Belongsto(Grade::class,'Grade_id');
    }
    public function Sections(){
        return $this->hasMany(Section::Class,'class_id');
    }

}
