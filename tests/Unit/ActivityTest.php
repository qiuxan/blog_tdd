<?php

namespace Tests\Unit;

use App\Activity;
use App\Project;
use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_has_a_user()
    {
        $user=$this->signIn();
        $project=ProjectFactory::ownedBy($user)->create();

        $this->assertEquals($user->id,$project->activity->first()->user->id);


//        $this->assertInstanceOf(User::class,$project->activity->first()->user);
    }
}
