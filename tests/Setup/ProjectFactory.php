<?php
/**
 * Created by PhpStorm.
 * User: xianqiu
 * Date: 5/4/19
 * Time: 11:06 AM
 */

namespace Tests\Setup;

use App\Project;
use App\Task;
use App\User;


class ProjectFactory
{

    protected $user;
    protected $tasksCount=0;

    public function ownedBy($user){
        $this->user=$user;
        return $this;
    }

    public function create()
    {
        $project= factory(Project::class)->create([

            'owner_id'=> $this->user ?? factory(User::class),
        ]);

        factory(Task::class,$this->tasksCount)->create([

            'project_id'=>$project->id
        ]);

        return $project;
    }

   public function withTask($count){
        $this->tasksCount=$count;
        return $this;
   }

}