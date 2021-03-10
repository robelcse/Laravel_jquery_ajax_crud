<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(){
        $teachers = Teacher::all();
        return view('teacher',compact('teachers'));
    }
    public function store(Request $request){
        $teacher = new Teacher();
        $teacher->name = $request->name;
        $teacher->phone = $request->phone;
        $teacher->description = $request->description;
        $teacher->save();
        return response()->json(['success'=>'teacher successfully saved']);
    }
}//end class
