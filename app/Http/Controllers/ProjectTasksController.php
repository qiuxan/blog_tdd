<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project){

        request()->validate(['body'=>'required']);
        $project->addTask(request('body'));

        return redirect($project->path());


    }
}
