<?php

use App\Http\Controllers\Classrooms\ClassroomController;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Sections\SectionController;
use App\Http\Controllers\Students\PromotionController;
use App\Http\Controllers\Students\StudentController;
use App\Http\Controllers\Teachers\TeacherController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::group(
    ['middleware' => ['guest'] ]
    , function () {

    Route::get('/', function () {
        return view('auth.login');
    });

});


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ], function () {

    Route::get('/dashboard',[HomeController::class, 'index'])->name('dashboard');


//    Route::group(['namespace' => 'Grades'], function () {
//        Route::resource('Grades', 'GradeController');
//    });

    Route::resource('Grades', GradeController::class);
    Route::resource('Classrooms', ClassroomController::class);
    Route::post('delete_all', [ClassroomController::class ,'deleteAll'])->name('delete_all');
    Route::post('Filter_Classes', [ClassroomController::class,'Filter_Classes'])->name('Filter_Classes');
    Route::resource('Sections', SectionController::class);
Route::get('/classes/{id}' ,[SectionController::class,'getclasses' ]);

    Route::view('add_parent','livewire.show_Form');


    Route::resource('Teachers', TeacherController::class);
    Route::resource('Students', StudentController::class);
    Route::get('/Get_classrooms/{id}', [StudentController::class,'Get_classrooms']);
    Route::get('/Get_Sections/{id}', [StudentController::class,'Get_Sections']);
    Route::post('/Upload_attachment', [StudentController::class,'Upload_attachment'])->name('Upload_attachment');
    Route::get('/Download_attachment/{studentsname}/{filename}', [StudentController::class,'Download_attachment']);
    Route::post('/Delete_attachment', [StudentController::class,'Delete_attachment'])->name('Delete_attachment');


    Route::resource('Promotions', PromotionController::class);

}


);





