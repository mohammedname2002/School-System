<?php

namespace App\Http\Controllers\Classrooms;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassrooms;
use App\Http\Requests\StoreGrades;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{

    public function index()
    {
        $Classrooms = Classroom::all();
        $Grades = Grade::all();
        return view('pages.classrooms.classrooms',[
            'Classrooms'=>$Classrooms,
                'Grades'=>$Grades,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(StoreClassrooms $request)
    {

     /*   if (Grade::where('Name->ar', $request->Name)->orWhere('Name->ar', $request->Name_en)->exists()) {

            return redirect()->back()->withErrors(trans('Grades_trans.exist'));
        }*/
        $List_Classes = $request->List_Classes;

        try{
            $validated = $request->validated();

        foreach ($List_Classes as $List_Class) {

            $My_Classes = Classroom::create(
                [
                    'Name' => ['en' => $List_Class['Name_class_en'], 'ar' => $List_Class['Name'] ],

                    'Grade_id' => $List_Class['Grade_id'],

                ]);


            $My_Classes->save();
        }

            toastr()->success(trans('messages.success'));

            return redirect()->route('Classrooms.index');
    }

    catch (\Exception $e){
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom $classroom)
    {
        //
    }

    public function update(Request $request)
    {

        try {

            $Classrooms = Classroom::findOrFail($request->id);

            $Classrooms->update([

                'Name_Class' => ['ar' => $request->Name, 'en' => $request->Name_en],
                'Grade_id' => $request->Grade_id,
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Classrooms.index');
        }

        catch(\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }


    }



    public function destroy(Request $request)
    {

        $Classrooms = Classroom::findOrFail($request->id)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Classrooms.index');

    }




    public function deleteAll(Request $request)
    {

        $delete_all_id =  explode(",", $request->delete_all_id); // تعمل هذه الفنكشن على عمل array لانو رح استخدم فنكشن اسمها whereIn وهذه تحتاج لفنكشن يعمل على تحويل لللا array
        Classroom::WhereIn('id', $delete_all_id)->Delete();

        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Classrooms.index');
    }



    public function Filter_Classes(Request $request)
    {
        $Grades = Grade::all();
        $Search = Classroom::select('*')->where('Grade_id','=',$request->Grade_id)->get();
        return view('pages.Classrooms.Classrooms',compact('Grades'))->withDetails($Search);

    }


}
