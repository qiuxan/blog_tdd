<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Facades\Tests\Setup\ProjectFactory;

class UserTest extends TestCase
{
    use RefreshDatabase;
//    /**
//     * A basic unit test example.
//     *
//     * @return void
//     */
//    public function testExample()
//    {
//        $this->assertTrue(true);
//    }

    /** @test*/
    public function a_user_has_projects()
    {
        $user=factory('App\User')->create();

        $this->assertInstanceOf(Collection::class,$user->projects);

    }

    /** @test */
    public function user_has_accessible_projects()
    {

        $john= $this->signIn();

        ProjectFactory::ownedBy($john)->create();

        $this->assertCount(1,$john->accseeibleProjects());

        $sally=factory(User::class)->create();

        $nick=factory(User::class)->create();

        $project=tap(ProjectFactory::ownedBy($sally)->create())->invite($nick);


        $this->assertCount(1,$john->accseeibleProjects());

        $project->invite($john);

        $this->assertCount(2,$john->accseeibleProjects());
    }

}
