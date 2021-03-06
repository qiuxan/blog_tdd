<?php

namespace Tests\Feature;

use App\Project;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
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
//        $this->actingAs(factory('App\User')->create());
        $this->signIn();
        $this->withoutExceptionHandling();

        $this->get('/projects/create')->assertStatus(200);


//

        $attributes = factory(Project::class)->raw();



        $this->followingRedirects()->post('/projects', $attributes=factory(Project::class)->raw(['owner_id'=>auth()->id()]))
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);


    }

    /** @test */
    public function a_user_can_update_a_project()
    {
//        $this->signIn();

        $project=ProjectFactory::create();
//        $this->withoutExceptionHandling();
        //$project=factory('App\Project')->create(['owner_id'=>auth()->id()]);

        $this->actingAs($project->owner)->patch($project->path(),$attribute=[
                'notes'=>'change',
                'title'=>'change',
                'description'=>'change'
            ]
        )->assertRedirect($project->path());

//        dd($project->path().'/edit');

        $this->get($project->path().'/edit')->assertOk();

        $this->assertDatabaseHas('projects',$attribute);
    }

    /** @test*/
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();
        $project=factory('App\Project')->create();
        $this->patch($project->path(),[])->assertStatus(403);

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

//

    /** @test */

    public function guest_can_not_control_projects(){


        $project =factory('App\Project')->create();

        //$this->withoutExceptionHandling();


        $this->get('/projects/edit')->assertRedirect('login');
        $this->get('/projects')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->post('/projects',$project->toArray())->assertRedirect('login');

    }


    /** @test*/

    public function it_belongs_to_an_owner()
    {
        $project =factory('App\Project')->create();
        $this->assertInstanceOf('App\User',$project->owner);
    }

    /** @test */
    public function a_user_can_update_a_projects_general_notes()
    {

        $project=ProjectFactory::create();
        $this->actingAs($project->owner)->patch($project->path(),$attribute=[
                'notes'=>'change',
            ]
        )->assertRedirect($project->path());

        $this->assertDatabaseHas('projects',$attribute);
    }

    /** @test */
    public function unauthorized_users_cannot_delete_project()
    {

        $project=ProjectFactory::create();

        $this->delete($project->path())
            ->assertRedirect('/login');
//        $this->assertDatabaseMissing('projects',$project->only('id'));

        $user=$this->signIn();

        $this->delete($project->path())->assertStatus(403);

        $project->invite($user);

        $this->actingAs($user)->delete($project->path())->assertStatus(403);

    }

    /** @test */
    public function a_user_can_delete_a_project()
    {

        $this->withoutExceptionHandling();

        $project=ProjectFactory::create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');
        $this->assertDatabaseMissing('projects',$project->only('id'));

    }

    /** @test */
    public function a_user_can_see_all_projects_they_involved()
    {

            $project=tap(ProjectFactory::create())->invite($this->signIn());

            $this->get('/projects')->assertSee($project->title);


    }

    /** @test */
    public function tasks_can_be_included_as_part_of_a_creation()
    {
        $this->signIn();

        $attributes=factory(Project::class)->raw();

        $attributes['tasks']=[
            ['body'=>'Task 1'],
            ['body'=>'Task2']
        ];


        $this->post('/projects',$attributes);

//        dd(Project::first());
        $this->assertCount(2, Project::first()->tasks);
    }
//    /** @test*/

//    public function a_user_can_view_their_project(){
//
//        $this->be(factory('App\User')->create());
//
//        $this->withoutExceptionHandling();
//
//        $project=factory('App\Project')->create(['owner_id'=>auth()->id()]);
//
//        $this->get($project->path())
//            ->assertSee($project->title)
//            ->assertSee($project->description);
//
//    }
}


