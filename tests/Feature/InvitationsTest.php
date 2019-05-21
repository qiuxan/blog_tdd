<?php

namespace Tests\Feature;

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


        $project->invite($newUser=factory(\App\User::class)->create());
        //and the owner of that project invites another user

       $this->signIn($newUser);


        // then that new user will have permission to add tasks
    }
}
