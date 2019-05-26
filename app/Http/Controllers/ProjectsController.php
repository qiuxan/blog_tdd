<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;

use App\Project;

class ProjectsController extends Controller
{
    //
    public function index(){

//        $projects=Project::all();

        $projects=auth()->user()->accseeibleProjects();

        return view('projects.index',compact('projects'));

    }

    public function create(){

        return view('projects.create');


    }

    public function store(){

        //validate

      //  dd('hehe');

        //dd(request());

        $project=auth()->user()->projects()->create($this->validateRequest());
        //persist
        //redirect

//        return redirect('/projects');
        return redirect($project->path());

    }

    public function show(Project $project){

        $this->authorize('update',$project);

//        if(auth()->user()->isNot($project->owner)){
//
//            abort(403);
//        }

        return view('projects.show',compact('project'));

    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }


    public function update(UpdateProjectRequest $request){


//        $project->update($request->validated());
        $request->save();
        return redirect($request->save()->path());
    }

//    /**
//     * @return array
//     */
    public function validateRequest()
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
    }

    public function destroy(Project $project){

        $this->authorize('update',$project);
        $project->delete();

        return redirect('/projects');

    }


}
