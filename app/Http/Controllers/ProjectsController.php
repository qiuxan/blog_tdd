<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;

class ProjectsController extends Controller
{
    //
    public function index(){

//        $projects=Project::all();

        $projects=auth()->user()->projects;

        return view('projects.index',compact('projects'));

    }

    public function create(){

        return view('projects.create');


    }

    public function store(){

        //validate


        $attributes=request()->validate([

            'title'=>'required',
            'description'=>'required',

        ]);

        //$attributes['owner_id']=auth()->id();

        auth()->user()->projects()->create($attributes);
        //persist
        //redirect

        return redirect('/projects');
    }

    public function show(Project $project){

        if(auth()->id()!=$project->owner_id){

            abort(403);
        }

        if(auth()->user()->isNot($project->owner)){

            abort(403);
        }



        return view('projects.show',compact('project'));

    }
}
