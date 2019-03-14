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
        $this->actingAs(factory('App\User')->create());
        $this->withoutExceptionHandling();
        $attributes=[
            'title'=>$this->faker->sentence,
            'description'=>$this->faker->paragraph,

        ];
        $this->post('projects',$attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects',$attributes);

        $this->get('/projects')->assertSee($attributes['title']);



    }
//
    /** @test */

    public function a_project_requires_a_title(){
        $this->actingAs(factory('App\User')->create());

        $attributes=factory('App\Project')->raw(['title'=>'']);

        $this->post('projects',$attributes)->assertSessionHasErrors('title');

    }
    /** @test */

    public function a_project_requires_a_description(){

        $this->actingAs(factory('App\User')->create());

        $attributes=factory('App\Project')->raw(['description'=>'']);

        $this->post('projects',$attributes)->assertSessionHasErrors('description');

    }
//

    /** @test*/
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->be(factory('App\User')->create());

//        $this->withoutExceptionHandling();
        $project=factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }


    /** @test*/

    public function a_user_can_view_their_project(){
        $this->be(factory('App\User')->create());

        $this->withoutExceptionHandling();

        $project=factory('App\Project')->create(['owner_id'=>auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);

    }

    /** @test */

    public function guest_can_not_create_projects(){


        //$this->withoutExceptionHandling();

        $attributes=factory('App\Project')->raw(['owner_id'=>null]);

        $this->post('projects',$attributes)->assertRedirect('login');


    }
    /** @test */

    public function only_authenticated_user_can_view_projects()
    {
        $this->get('projects')->assertRedirect('login');

    }
    /** @test */

    public function guest_can_not_view_single_projects()
    {

        $project =factory('App\Project')->create();
        $this->get('projects')->assertRedirect('login');

    }

    /** @test*/

    public function it_belongs_to_an_owner()
    {
        $project =factory('App\Project')->create();
        $this->assertInstanceOf('App\User',$project->owner);
    }
}


