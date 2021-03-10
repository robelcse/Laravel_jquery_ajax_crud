<?php

namespace App\Http\Controllers;

use App\Post;
use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function get_data(){

        return Student::all();
    }

    public function store_data(Request $request){
//        Student::create($request->all());
//        return ['success'=>true, 'message'=>'Student data inserted successfully.'];
        $request->validate([
            'name'       => 'name|max:255',
            'email' => 'email',
            'phone' => 'phone'
        ]);

        $post = Student::updateOrCreate(['id' => $request->id], [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return response()->json(['code'=>200, 'message'=>'Post Created successfully','data' => $post], 200);
    }

    public function update_data(Request $request, $id){


    }
    public function delete_data(Request $request){


    }

}//end class
