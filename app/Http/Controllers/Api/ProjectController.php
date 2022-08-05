<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    //all routes in project controller need authentication.
    
    //project create -- need auth
    public function createProject(Request $request)
    {

        //validation -- only need to validate the inputs. Rest comes from Sanctum.
        $request->validate([

            'name' => 'required',
            'description' => 'required',
            'duration' => 'required'
        ]);

        //student id -- student controller under profile function and create project
        $student_id = auth()->user()->id;

        $project = New Project();

        $project->student_id = $student_id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->duration = $request->duration;

        $project->save();

        //send response
        return response()->json([
            
            'status' => 1,
            'message' => 'Project created successfully.'


        ]);


    }

    //project list by student id -- need auth
    public function listProject()
    {

        //student id and create project
        $student_id = auth()->user()->id;

        //get projects
        $projects = Project::where('student_id', $student_id)->get();

        //send response
        return response()->json([
            'status' => 1,
            'message' => 'Listing projects', 
            'data' => $projects
        ], 200);

    }
    
    //get single project detail -- need auth
    public function singleProject($id)
    {

        $student_id = auth()->user()->id;

        if(Project::where([

            'id' => $id,
            'student_id' => $student_id

        ], $id)->exists()){

            $project_detail = Project::where([

                'id' => $id,
                'student_id' => $student_id
    
            ], $id)->first();

            return response()->json([

                'status' => 1,
                'message' => 'Student found',
                'data' => $project_detail
            ]);


        } else {

            return response()->json([

                'status' => 0,
                'message' => 'Project not found'

            ], 404);
        }


    }
    
    //project delete -- need auth
    public function deleteProject($id)
    {


        $student_id = auth()->user()->id;

        if(Project::where([

            'id' => $id,
            'student_id' => $student_id

        ], $id)->exists()){

            $project = Project::where([

                'id' => $id,
                'student_id' => $student_id
    
            ], $id)->first();

            $project->delete();
            
            return response()->json([

                'status' => 1,
                'message' => 'Project deleted successfully.'
            ]);

        } else {

            return response()->json([

                'status' => 0,
                'message' => 'Project not found'

            ], 404);


        }

    }
    
}