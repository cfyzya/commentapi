<?php

namespace Tests\Unit;

use App\Models\Comments;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{

    use RefreshDatabase;

    public function test_validation_error(): void
    {

        Sanctum::actingAs(
            User::factory()->create(),
            ['view-tasks']
        );

        $this->json('post', 'api/comments')->assertStatus(422);
    }

    public function test_auth(): void
    {

        $response = $this->json('post', 'api/comments')->assertStatus(401);
    }

    public function test_comments_create(): void
    {

        Sanctum::actingAs(
            User::factory()->create(),
        );

        $news = News::factory()->create();

        $this->json('post', 'api/comments',['news_id' => $news->id, 'comment_text' => 'lorem ipsum'])
            ->assertStatus(200);
    }

    public function test_comments_get_by_id()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $comments = Comments::factory()->create();

        $this->json('get', 'api/comments/' . $comments->id)->assertStatus(200);
    }

    public function test_update_comment()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $comments = Comments::factory()->create();

        $this
            ->json(
                'put',
                'api/comments/' . $comments->id,
                ['comment_text' => 'lorem ipsum', 'news_id' => $comments->news_id]
            )
            ->assertStatus(200);
    }

    public function test_delete_comment()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $comments = Comments::factory()->create();

       $this->json(
                'delete',
                'api/comments/' . $comments->id,
                ['comment_text' => 'lorem ipsum', 'news_id' => $comments->news_id]
            )
            ->assertStatus(200);
    }

    public function test_search()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $comments = Comments::factory()->count(5)->create();

        $searcheblaeComments = $comments[0];

        $response = $this->json(
            'get',
            'api/comments/search',
            ['search' => substr($searcheblaeComments->comment_text, '5')]
        )
            ->getContent();

        $this->assertEquals(json_decode($response), json_decode(json_encode([$searcheblaeComments])));
    }
}
