<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentResourceCollection;

class StudentController extends Controller
{
    //
    public function show(Student $student) 
    {
        return $student;
    }
    public function index()
    {
        $a = new StudentResourceCollection(Student::paginate());
        return $a->collection;
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'dob' => 'required',
            'age' => 'required',
        ])  ;  
        $student = Student::create($request->all());
        return $student;
    }
    public function update(Student $student, Request $request) :StudentResource
    {
        $student->update($request->all());
        return new StudentResource($student);
    }
    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json();
    }



}
