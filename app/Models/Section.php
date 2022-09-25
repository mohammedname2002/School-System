<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasFactory;
    use HasTranslations;
    public $timestamps = true;
    protected $table = 'sections';

    public $translatable = ['Name_Section'];
    protected $fillable = ['Name_Section' , 'status' , 'Grade_id' ,'Class_id'];

    public function Grades(){

        return   $this->Belongsto(Grade::class,'Grade_id');
    }

    public function Classrooms(){

        return   $this->Belongsto(Classroom::class ,'Class_id');
    }
    public function Teachers()
    {
        return $this->belongsToMany(Teacher::class  ,'section_teacher');
    }

}
