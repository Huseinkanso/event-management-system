<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /** @test */
    public function user_can_update_event()
    {
        //prepare
        $event=Event::factory()->create();
        $newEvent=$event;
        $newEvent->name='name';
        //act
        $this->patch('eventile/new-event',$newEvent->toArray());
        //assert
        $this->assertDatabaseHas('events',['name'=>'name']);
    }
}
