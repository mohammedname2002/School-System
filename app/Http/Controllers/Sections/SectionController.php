<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGrades;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SectionController extends Controller
{




    public function index()
    {
        $Grades = Grade::with(['Sections'])->get();
        $list_Grades = Grade::all();
$Teachers = Teacher::all();
        return view('pages.sections.sections', [
            'Grades' => $Grades,
            'list_Grades' => $list_Grades,
            'Teachers'=>$Teachers,

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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $Sections = Section::create([

                'Name_Section' => ['en' => $request->Name_Section_En, 'ar' => $request->Name_Section_Ar],
                'Grade_id' => $request->Grade_id,
                'status'=>1,
                'Class_id' => $request->Class_id,
            ]);

            $Sections->save();
            $Sections->Teachers()->attach($request->teacher_id);

            toastr()->success(trans('messages.success'));

            return redirect()->route('Sections.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }





    public function update(Request $request)
    {
        try {

            //$validated = $request->validated();
            $Sections = Section::findOrFail($request->id);
            $Sections->update([
                'Name_Section' => ['en' => $request->Name_Section_En, 'ar' => $request->Name_Section_Ar],
                'Grade_id' => $request->Grade_id,
                'status'=>1,
                'Class_id' => $request->Class_id,
            ]);



            if(isset($request->Status)) {
                $Sections->Status = 1;
            } else {
                $Sections->Status = 2;
            }

            // update pivot tABLE
            if (isset($request->teacher_id)) {
                $Sections->Teachers()->sync($request->teacher_id);//
            } else {
                $Sections->Teachers()->sync(array());
            }
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Sections.index');
        }
        catch
        (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy(Request $request)
    {
        Section::findOrFail($request->id)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Sections.index');
    }

    public function getclasses($id)
    {

$list_classes = Classroom::where('Grade_id' ,$id )->pluck('Name' , 'id');
return $list_classes;


    }
}
