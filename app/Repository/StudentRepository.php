<?php

namespace App\Repository;


use App\Http\Requests\StoreStudents;
use App\Models\Classroom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Image;
use App\Models\My_Parent;
use App\Models\Nationalitie;
use App\Models\Section;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Type_Blood;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentRepository implements StudentRepositoryInterface{

    public function Get_Student(){

        $students = Student::all();
        return view('pages.Students.index' ,
        [
            'students'=>$students
        ]);
    }

    public function Create_Student(){
        $data['my_classes'] = Grade::all();
        $data['parents'] = My_Parent::all();
        $data['Genders'] = Gender::all();
        $data['nationals'] = Nationalitie::all();
        $data['bloods'] = Type_Blood::all();
return view('pages.Students.add' , $data);
    }

    public function Get_classrooms($id){

        $list_classes = Classroom::where("Grade_id", $id)->pluck("Name", "id");
        return $list_classes;

    }


    //Get Sections
    public function Get_Sections($id){

        $list_sections = Section::where("Class_id", $id)->pluck("Name_Section", "id");
        return $list_sections;
    }
    public function Store_Students( $request){
DB::beginTransaction();

        try {

     /*       $Students =new Student;

            $Students->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $Students->email = $request->Email;
            $Students->Password = Hash::make($request->Password);
            $Students->nationalitie_id = $request->nationalitie_id;
            $Students->blood_id = $request->blood_id;
            $Students->Date_Birth = $request->Date_Birth;
            $Students->Grade_id = $request->Grade_id;
            $Students->Classroom_id = $request->Classroom_id;
            $Students->section_id = $request->section_id;
            $Students->parent_id = $request->parent_id;
            $Students->academic_year = $request->academic_year;
            $Students->gender_id = $request->Gender_id;  */


            $students = new Student();
            $students->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $students->email = $request->email;
            $students->password = Hash::make($request->password);
            $students->gender_id = $request->gender_id;
            $students->nationalitie_id = $request->nationalitie_id;
            $students->blood_id = $request->blood_id;
            $students->Date_Birth = $request->Date_Birth;
            $students->Grade_id = $request->Grade_id;
            $students->Classroom_id = $request->Classroom_id;
            $students->section_id = $request->section_id;
            $students->parent_id = $request->parent_id;
            $students->academic_year = $request->academic_year;
            $students->save();

            // insert img
            if($request->hasfile('photos'))
            {
                foreach($request->file('photos') as $file)
                {
                    $name = $file->getClientOriginalName();
                    $file->storeAs('attachments/students/'.$students->name, $file->getClientOriginalName(),'upload_attachments');

                    // insert in image_table
                    $images= new Image();
                    $images->filename=$name;
                    $images->imageable_id= $students->id;
                    $images->imageable_type = 'App\Models\Student';
                    $images->save();
                }
            }
            toastr()->success(trans('messages.success'));
            return redirect()->route('Students.index');
            DB::commit();

        }
        catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }
    public function Show_Student($id)
    {
        $Student = Student::findorfail($id);
        return view('pages.Students.show',compact('Student'));
    }
    public function Upload_attachment($request){

        foreach($request->file('photos') as $file)
        {
            $name = $file->getClientOriginalName();
            $file->storeAs('attachments/students/'.$request->student_name, $file->getClientOriginalName(),'upload_attachments');

            // insert in image_table
            $images= new image();
            $images->filename=$name;
            $images->imageable_id = $request->student_id;
            $images->imageable_type = 'App\Models\Student';
            $images->save();
        }
        toastr()->success(trans('messages.success'));
        return redirect()->route('Students.show',$request->student_id);
    }

    public function Download_attachment($studentsname , $filename){

       return response()->download(public_path('attachments/students/'.$studentsname.'/'.$filename));

}



        public function edit_Students($id){
        $Grades = Grade::all();
       $parents = My_Parent::all();
        $Genders= Gender::all();
       $nationals = Nationalitie::all();
        $bloods = Type_Blood::all();

        $Students = Student::find($id);
        return view('pages.Students.edit' , [
            'Students'=>$Students,
            'Grades'=> $Grades,
            'parents'=> $parents ,
            'Genders'=> $Genders ,
            'nationals'=> $nationals ,
            'bloods'=>$bloods  ,

        ] );
    }

    public function Delete_Students($request){

        Student::destroy($request->id);
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Students.index');


    }


    public function Update_Students($request)
    {

        try {

            $students = Student::findOrFail($request->id);


            $students->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $students->email = $request->email;
            $students->password = Hash::make($request->password);
            $students->gender_id = $request->gender_id;
            $students->nationalitie_id = $request->nationalitie_id;
            $students->blood_id = $request->blood_id;
            $students->Date_Birth = $request->Date_Birth;
            $students->Grade_id = $request->Grade_id;
            $students->Classroom_id = $request->Classroom_id;
            $students->section_id = $request->section_id;
            $students->parent_id = $request->parent_id;
            $students->academic_year = $request->academic_year;
            $students->save();
            toastr()->success(trans('messages.success'));
            return redirect()->route('Students.index');

        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }




    }


    public function Delete_attachment($request)
    {
        // Delete img in server disk
        Storage::disk('upload_attachments')->delete('attachments/students/'.$request->student_name.'/'.$request->filename);

        // Delete in data
        image::where('id',$request->id)->where('filename',$request->filename)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Students.show',$request->student_id);
    }


}

