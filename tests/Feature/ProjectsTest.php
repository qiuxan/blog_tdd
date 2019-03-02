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
        $attributes=[
            'title'=>$this->faker->sentence,
            'description'=>$this->faker->paragraph,

        ];
        $this->post('projects',$attributes);

        $this->assertDatabaseHas('projects',$attributes);



    }


}
