<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return view('main');

    }

    public function dataShow()
    {
        $data = Student::orderBy('id','desc')->get();
        return response()->json($data);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'contact'=> 'required',
            'email' => 'required'
        ]);

        // $data = new Student;

        // $data->name = $request->input('name');
        // $data->email = $request->input('email');
        // $data->contact = $request->input('contact');
        // $data->save();

        $data = Student::create([
            'name' => $request->input('name'),
            'email'=> $request->input('email'),
            'contact'=> $request->input('contact'),
        ]);

        return response()->json($data);
    }

    public function edit($id)
    {
        $data = Student::findOrfail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'contact'=> 'required',
            'email' => 'required'
        ]);

        $data = Student::findOrFail($id)->update([
            'name' => $request->input('name'),
            'email'=> $request->input('email'),
            'contact'=> $request->input('contact'),
        ]);

        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = Student::findOrFail($id)->delete();

        return response()->json($data);
    }

}
