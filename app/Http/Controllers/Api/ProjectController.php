<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{ 
    // create project api 
    public function createProject(Request $request){
            // validation 
         $request->validate([
             "name" => "required",
             "description" => "required",
             "duration" => "required"
         ]);
            //student id + create data
         $student_id = auth()->user()->id;
        
         $project = new Project();
         
         $project->student_id = $student_id;
         $project->name = $request->name;
         $project->description = $request->description;
         $project->duration = $request->duration;
           
         $project->save();

          // response 

         return response()->json([
             "status" => 1,
             "message" => "Project has been created"
         ]) ;

    }
   // list project api 
    public function listProject(){
         $student_id = auth()->user()->id;

         $projects = Project::where("student_id", $student_id)->get();

         return response()->json([
               "status" => 1,
               "message" => "Projects",
               "data" => $projects
         ]);
    }
   // single project api 
    public function singleProject($id){
          if(Project::where("id",$id)->exists()){
              $details = Project::find($id);

              return response()->json([
                  "status" => 1,
                  "message" => "Project details",
                  "data"=> $details
              ]);

          }else{
            return response()->json([
                "status" => 0,
                "message" => "Project not found"
          ]);
          }
    }
   // delete project api 
    public function deleteProject($id){

         $studentid = auth()->user()->id;
         
         if(Project::where([
             "id" => $id,
             "student_id"=>$studentid
         ])->exists()){
             $project = Project::where([
                "id"=> $id,
                "student_id" => $studentid
             ])->first();

             $project->delete();

             return response()->json([
                "status" => 1,
                "message" => "Project delete successfully"
             ]);

         }else{
            return response()->json([
                "status" => 0,
                "message" => "Project not found"
          ]);
         }
    }

}
