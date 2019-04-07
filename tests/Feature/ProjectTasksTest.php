<?php

namespace Tests\Feature;

use App\Http\Controllers\ProjectsController;
use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\ProjectFactory;

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

        $project=factory(Project::class)->create();

        $task=$project->addTask('test task');


        $this->patch($task->path(),['body'=>'changed task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks',['body'=>'changed task']);

    }

    /** @test */
    public function a_task_can_be_updated()
    {

        $this->withoutExceptionHandling();

        $project=app(ProjectFactory::class)->ownedBy($this->signIn())->withTask(1)->create();
       // $this->signIn();


//        $project=auth()->user()->projects()->create(
//            factory(Project::class)->raw()
//        );
//
//
//
//        $task=$project->addTask('test task');

        $this->patch($project->path().'/tasks/'.$project->tasks[0]->id,[
            'body'=>'changed',
            'completed'=>true

        ]);
        $this->assertDatabaseHas('tasks',[
            'body'=>'changed',
            'completed'=>true
        ]);

    }

}
