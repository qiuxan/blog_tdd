<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker,RefreshDatabase;
//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function testExample()
//    {
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
//    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        $attributes=[
            'title'=>$this->faker->sentence,
            'description'=>$this->faker->paragraph,

        ];
        $this->post('projects',$attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects',$attributes);

        $this->get('/projects')->assertSee($attributes['title']);



    }

    /** @test */

    public function a_project_requires_a_title(){

        $attributes=factory('App\Project')->raw(['title'=>'']);

        $this->post('projects',$attributes)->assertSessionHasErrors('title');

    }
    /** @test */

    public function a_project_requires_a_description(){

        $attributes=factory('App\Project')->raw(['description'=>'']);

        $this->post('projects',$attributes)->assertSessionHasErrors('description');

    }

    /** @test*/

    public function a_user_can_view_a_project(){

        $this->withoutExceptionHandling();

        $project=factory('App\Project')->create();
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);

    }


}


