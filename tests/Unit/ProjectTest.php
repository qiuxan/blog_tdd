<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
//   /** @test*/
//    public function it_has_a_path()
//    {
//        $project=factory('App\Project')->create();
//
//        $this->assertEquals('/projects/'.$project->id, $project->path());
//    }
    /** @test*/
    public function it_can_add_a_task()
    {

        $project=factory('App\Project')->create();

//        $project->addTask('test task');

        $task=$project->addTask('test Task');

        $this->assertCount(1,$project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }


}
