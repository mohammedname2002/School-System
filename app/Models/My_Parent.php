<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class My_Parent extends Model
{

    use HasFactory;
    use HasTranslations;

    public $translatable = ['Name_Father','Job_Father','Job_Mother','Name_Mother'];
    protected $guarded =[];


    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
