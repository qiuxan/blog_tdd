<?php

namespace Tests\Feature;

use App\Http\Controllers\ProjectsController;
use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{


    use RefreshDatabase;

    /** @test*/

    public function a_project_can_add_tasks(){

//        $this->withoutExceptionHandling();
        $this->signIn();

        $project=auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

//        $project=factory(Project::class)->create(['owner_id'=>auth()->id()]);

        $this->post($project->path().'/tasks',['body'=>'task body']);

        $this->get($project->path())
            ->assertSee('task body');


    }

    /** @test */
    public function a_task_require_a_body()
    {
        $this->signIn();
        $project=auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );
        $attributes=factory('App\Task')->raw(['body'=>'']);
        $this->post($project->path().'/tasks',$attributes)->assertSessionHasErrors('body');
    } 



}
