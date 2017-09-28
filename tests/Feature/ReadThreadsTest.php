<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{

    use DatabaseMigrations;

    protected $thread;

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
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_all_replies_associated_with_a_single_thread()
    {
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $threadNotByJane = create ('App\Thread');

        $user = create('App\User', ['name' => 'JaneDoe']);
        $this->signIn($user);

        $threadByJane = create('App\Thread', ['user_id' => auth()->id()]);

        $this->get('/threads?by=JaneDoe')
        ->assertSee($threadByJane->title)
        ->assertDontSee($threadNotByJane->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        // Given we have three threads
        // With 2 replies, 3 replies, and 0 replies, respectively
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies], 3);

        $threadWithZeroReplies = $this->thread;

        // when I filter all threads by popularity
        $response = $this->getJson('threads?popular')->json();

        // then they should be returned from most replies to least
        $this->assertEquals( [3, 2, 0], array_column( $response, 'replies_count' ) );
    }
}
