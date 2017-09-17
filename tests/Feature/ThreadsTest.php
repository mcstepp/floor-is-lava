<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test  */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test  */
    public function a_user_can_view_a_single_thread()
    {
        $this->get('/threads/' . $this->thread->id)
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_all_replies_associated_with_a_single_thread()
    {
        // And that thread includes replies
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

        // When we visit a thread page
        $this->get($this->thread->path())
            ->assertSee($reply->body);

        // We should see replies
    }
}
