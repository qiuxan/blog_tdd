<?php namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordActivityTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function create_a_project()
    {
       $project=ProjectFactory::create();

       $this->assertCount(1, $project->activity);
       $this->assertEquals('created',$project->activity[0]->description);
    }

    /** @test */
    public function updating_a_project()
    {

        $project=ProjectFactory::create();

        $project->update(['title'=>'Changed']);

        $this->assertCount(2,$project->activity);

        $this->assertEquals('updated', $project->activity->last()->description);
    }

    /** @test */
    public function creating_a_new_task()
    {
        $project=ProjectFactory::create();

        $project->addTask('some task');


        $this->assertEquals('created_task', $project->activity->last()->description);
        $this->assertCount(2,$project->activity);
    }

    /** @test */
    public function completing_a_task()
    {
        $project=ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(),[
            'body'=>'foobar',
            'completed'=>true
        ]);


        $this->assertEquals('completed_task', $project->activity->last()->description);
        $this->assertCount(3,$project->activity);
    }

    /** @test */
    public function incompleting_a_task()
    {
        $project=ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(),[
            'body'=>'foobar',
            'completed'=>true
        ]);


//        $this->assertEquals('completed_task', $project->activity->last()->description);
        $this->assertCount(3,$project->activity);

        $this->patch($project->tasks[0]->path(),[
            'body'=>'foobar',
            'completed'=>false
        ]);
        $project->refresh();
        $this->assertCount(4,$project->activity);

        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }
}
