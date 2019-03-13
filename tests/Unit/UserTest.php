<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

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

}
