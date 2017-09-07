<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test  */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have an authenticated user
        $user = factory('App\User')->create();
        $this->be($user);

        // And an existing thread
        $thread = factory('App\Thread')->create();
        // When a user makes a reply on the thread
        $reply = factory('App\Reply')->make();
        $this->post($thread->path() .'/replies', $reply->toArray());

        // Their reply should be included on the page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
