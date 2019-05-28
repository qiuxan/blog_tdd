<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function non_owner_cannot_invite_users()
    {
//        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create())
            ->post(ProjectFactory::create()->path().'/invitations')
            ->assertStatus(403);

    }

    /** @test */
    public function the_invited_email_must_be_a_valid_app_account()
    {
        $project=ProjectFactory::create();
        $this->actingAs($project->owner)->post($project->path().'/invitations',[
            'email' =>'wronguser@gmail.com'
        ])->assertSessionHasErrors([
            'email'=>'The Invited User Must Have An Account!'
        ]);



    }

    /** @test */
    public function a_project_can_invite_a_user()
    {

        $this->withoutExceptionHandling();

        $project=ProjectFactory::create();

        $userToInvite=factory(User::class)->create();

        $this->actingAs($project->owner)->post($project->path().'/invitations',[
            'email' => $userToInvite->email
        ])
        ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */
    public function invited_users_can_update_project_details()
    {
        $project=ProjectFactory::create();

        //given I have a project


        $project->invite($newUser = factory(User::class)->create());

        //and the owner of that project invites another user

       $this->signIn($newUser);

       $this->post(action('ProjectTasksController@store', $project), $task = ['body' => 'Foo task']);


        // then that new user will have permission to add tasks

        $this->assertDatabaseHas('tasks',$task);
    }


}
