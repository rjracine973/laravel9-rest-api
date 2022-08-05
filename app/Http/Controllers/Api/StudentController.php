<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;




class StudentController extends Controller
{
    
    //student register -- auth not needed
    public function register(Request $request)
    {

        //validation
        $request->validate([

            'name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required|confirmed'
            //phone is optional parameter. Migration should reflect nullable field.
        ]);

        //create data.  This calls the student model.
        $student = New Student();

        $student->name = $request->name;
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->phone = isset($request->phone) ? $request->phone : '';

        $student->save();

        //send response
        return response()->json([
            
            'status' => 1,
            'message' => 'Student created successfully.'

        ]);    
        
    }
    
    //student login -- auth not needed
    public function login(Request $request)
    {


        //validation
        $request->validate([

            'email' => 'required|email',
            'password' => 'required'
        ]);


        //check student model for email passed in request.
        $student = Student::where('email', '=', $request->email)->first();

        //valid student email address will return the information in db about the student.
        if(isset($student->id)){

            if(Hash::check($request->password, $student->password)){

                //create token
                $token = $student->createToken('auth_token')->plainTextToken;


                //send response
                return response()->json([
            
                    'status' => 1,
                    'message' => 'Student login successful.',
                    'access_token' => $token
        
                ]);    

            } else {


                return response()->json([

                    'status' => 0,
                    'message' => 'Password did not match.'
    
                ], 404);


            }

            

        } else {

            return response()->json([

                'status' => 0,
                'message' => 'Student not found'

            ], 404);

        }

    }
    
    
    //student profile -- auth needed
    //Sanctum token must be passed into header to provide access to resource.
    public function profile()
    {

        return response()->json([
            
            'status' => 1,
            'message' => 'Student profile information.',
            'data' => auth()->user()

        ]);    
    }

    //student logout -- auth needed
    public function logout()
    {


        //Not sure why this error is shown.  Chk Laravel 9 Sanctum docs.
        auth()->user()->tokens()->delete();

        return response()->json([
            
            'status' => 1,
            'message' => 'Student logged out.'

        ]);    



    }



    //Create API -- POST request
    //http://127.0.0.1:8000/api/add-student
    public function createStudent(Request $request)
    {

        
        //validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'phone' => 'required'
        ]);
        

        //create data
        $student = New Student();

        $student->name = $request->name;
        $student->email = $request->email;
        $student->password = $request->password;
        $student->phone = $request->phone;

        $student->save();

        //send response
        return response()->json([
            
            'status' => 1,
            'message' => 'Student created successfully.'

        ]);    
    }

    //listStudent API -- GET request
    //http://127.0.0.1:8000/api/list-students
    public function listStudents()
    {

        //$students = Student::get()->toArray();
        $students = Student::get();

        //print_r($students);

        return response()->json([
            'status' => 1,
            'message' => 'Listing Students', 
            'data' => $students
        ], 200);

    }

    //getSingleStudent API -- GET request
    //http://127.0.0.1:8000/api/list-single-student/10
    public function getSingleStudent($id)
    {

        if(Student::where('id', $id)->exists()){

            $student_detail = Student::where('id', $id)->first();

            return response()->json([

                'status' => 1,
                'message' => 'Student found',
                'data' => $student_detail
            ]);


        } else {

            return response()->json([

                'status' => 0,
                'message' => 'Student not found'

            ], 404);


        }

    }
    
    //updateStudent API -- PUT request
    //http://127.0.0.1:8000/api/update-student/10
    public function updateStudent(Request $request, $id)
    {

        if(Student::where('id', $id)->exists()){

            $student = Student::find($id);

            $student->name = !empty($request->name) ? $request->name : $student->name;
            $student->email = !empty($request->email) ? $request->email : $student->email;
            $student->password= !empty($request->password) ? $request->password : $student->password;
            $student->phone= !empty($request->phone) ? $request->phone : $student->phone;
            
            
            $student->save();

            return response()->json([

                'status' => 1,
                'message' => 'student updated successfully.',
                'data' => $student
            ]);

        } else {

            return response()->json([

                'status' => 0,
                'message' => 'Student not found'

            ], 404);


        }

    }
    
    //deleteStudent API -- DELETE request
    //http://127.0.0.1:8000/api/delete-student/10
    public function deleteStudent($id)
    {

        if(Student::where('id', $id)->exists()){

            $student = Student::find($id);

            $student->delete();
            
            return response()->json([

                'status' => 1,
                'message' => 'Student deleted successfully.'
            ]);

        } else {

            return response()->json([

                'status' => 0,
                'message' => 'Student not found'

            ], 404);


        }

    }

}
