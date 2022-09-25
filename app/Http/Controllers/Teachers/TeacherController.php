<?php

namespace App\Http\Controllers\Teachers;
use App\Http\Requests\StoreTeacher;
use App\Repository\TeacherRepositoryInterface;

use App\Http\Controllers\Controller;
use Request;

class TeacherController extends Controller
{


    protected $Teacher;

    public function __construct(TeacherRepositoryInterface $Teacher)
    {
        $this->Teacher = $Teacher;
    }

    public function index()
{
$Teachers = $this->Teacher->getaAllTeachers();
return view('Pages.Teachers.Teachers' , [
'Teachers'=>$Teachers,]
);
}


public function create(){
    $specializations = $this->Teacher->Getspecialization();
    $genders = $this->Teacher->GetGender();
    return view('pages.Teachers.create',compact('specializations','genders'));
}


    public function store(StoreTeacher $request)
    {
        return $this->Teacher->StoreTeachers($request);
    }

    public function edit($id)
    {
        $Teachers = $this->Teacher->editTeachers($id);
        $specializations = $this->Teacher->Getspecialization();
        $genders = $this->Teacher->GetGender();
        return view('pages.Teachers.edit',compact('Teachers','specializations','genders'));
    }

    public function update(\Illuminate\Http\Request $request)
    {
        return $this->Teacher->UpdateTeachers($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\Illuminate\Http\Request $request)
    {
        return $this->Teacher->DeleteTeachers($request);
    }
}
