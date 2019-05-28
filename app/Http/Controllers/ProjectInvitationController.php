<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationRequest;
use App\Project;
use App\User;
use Illuminate\Http\Request;

class ProjectInvitationController extends Controller
{
    //

    public function store(Project $project,ProjectInvitationRequest $request)
    {




//        $this->authorize('update', $project);
//        request()->validate([
//            'email'=>['exists:users,email','required']
//        ],['email.exists'=>'The Invited User Must Have An Account!']);




        $user= User::whereEmail(request('email'))->first();

        $project->invite($user);

        return redirect($project->path());
    }
}
