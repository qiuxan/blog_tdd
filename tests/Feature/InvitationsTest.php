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
    public function a_project_can_invited_a_user()
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
