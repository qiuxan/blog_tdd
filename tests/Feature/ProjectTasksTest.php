<?php

namespace Tests\Feature;

use App\Http\Controllers\ProjectsController;
use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

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
        //$this->signIn();

        $project=ProjectFactory::create();

//        $project=auth()->user()->projects()->create(
//            factory(Project::class)->raw()
//        );


        $attributes=factory('App\Task')->raw(['body'=>'']);
        $this->actingAs($project->owner)->post($project->path().'/tasks',$attributes)->assertSessionHasErrors('body');




    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();

        $project=factory(Project::class)->create();



        $this->post($project->path().'/tasks',['body'=>'test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks',['body'=>'test task']);

    }


    /** @test */
    public function only_the_owner_of_a_project_may_update_tasks()
    {
        $this->signIn();
        $project= ProjectFactory::withTask(1)->create();

//dd($project->tasks[0]);
        $this->patch($project->tasks[0]->path(),['body'=>'changed task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks',['body'=>'changed task']);

    }

    /** @test */
    public function a_task_can_be_updated()
    {

        $project= ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(),[
            'body'=>'changed',

        ]);
        $this->assertDatabaseHas('tasks',[
            'body'=>'changed',
        ]);

    }

    /** @test */
    public function a_task_can_be_completed()
    {

        $project= ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(),[
                'body'=>'changed',
                'completed'=>true

            ]);
        $this->assertDatabaseHas('tasks',[
            'body'=>'changed',
            'completed'=>true
        ]);

    }

    /** @test */
    public function a_task_can_be_marked_as_incomplete()
    {

        $project= ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(),[
                'body'=>'changed',
                'completed'=>true

            ]);

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(),[
                'body'=>'changed',
                'completed'=>false

            ]);

        $this->assertDatabaseHas('tasks',[
            'body'=>'changed',
            'completed'=>false
        ]);

    }
}
