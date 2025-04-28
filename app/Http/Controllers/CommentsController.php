<?php

namespace App\Http\Controllers;

use App\DTOs\CommentsDTO;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comments;
use App\Models\News;
use App\Services\CommentService;
use App\Services\SearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;


/**
 * @OA\SecurityScheme(
 *        securityScheme="bearerAuth",
 *        type="http",
 *        scheme="bearer",
 *        bearerFormat="JWT",
 *   ),
 */
class CommentsController extends Controller
{
    public function __construct(
        private CommentService $commentsService,
        private SearchService $searchService,
    )
    {
    }

    /**
     * @param Request $request
     *
     * @OA\Post(
     *     path="/comments/{comment_id}",
     *     summary="Create a new Comment",
     *     tags={"Comment"},
     *      @OA\Parameter(name="comment_id", in="path", description="comment id", required=true, @OA\Schema(description="comment id", type="integer",)),
     *      @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(
     *               required={"comment_text","news_id"},
     *               @OA\Property(property="comment_text", type="string", example="some kind of comment text"),
     *               @OA\Property(property="news_id", type="integer", example="2")
     *           ),
     *       ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function create(CreateCommentRequest $request)
    {
        try {
            $comment = $this->commentsService->create(CommentsDTO::fromRequest($request));
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }

        return $comment->toResource();
    }

    /**
     * @param Comments $comment
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Put(
     *    path="/comments/{comment_id}",
     *    summary="Update an existing comment",
     *    tags={"Comment"},
     *     @OA\Parameter(name="comment_id", in="path", description="comment id", required=true, @OA\Schema(description="comment id", type="integer",)),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"comment_text","news_id"},
     *              @OA\Property(property="comment_text", type="string", example="some kind of comment text"),
     *              @OA\Property(property="news_id", type="integer", example="2")
     *          ),
     *      ),
     *    @OA\Response(response=200, description="Successful operation"),
     *    @OA\Response(response=400, description="Invalid request")
     *)
 */
    public function update(Comments $comment, UpdateCommentRequest $request)
    {
        try {
            $comment = $this->commentsService->update($comment->id, CommentsDTO::fromRequest($request));
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json($exception->getMessage(), 500);
        }

        return $comment->toResource();
    }

    /**
     * @param Comments $comment
     * @return JsonResource
     *
     * @OA\Get(
     *      path="/comments/{comment_id}",
     *      summary="get a comment data by id",
     *      tags={"Comment"},
     *       @OA\Parameter(name="comment_id", in="path", description="comment id", required=true, @OA\Schema(description="comment id", type="integer",)),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Invalid request")
     *  )
     */
    public function getById(Comments $comment)
    {
        return $comment->toResource();
    }

    /**
     * @param News $news
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/comments/news/{news_id}",
     *     summary="Get all comennts by news_id",
     *     tags={"Comment"},
     *      @OA\Parameter(name="news_id", in="path", description="news id", required=true, @OA\Schema(description="news id", type="integer",)),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function getByNewsId(News $news)
    {
        $comments = $this->commentsService->getByNewsId($news->id);
        return $comments->toResourceCollection();
    }

    /**
     * @param Comments $comment
     * @return JsonResponse
     *
     *
     *
     * @OA\Delete(
     *      path="/comments/{comment_id}",
     *      summary="Delete comment by id",
     *      tags={"Comment"},
     *       @OA\Parameter(name="comment_id", in="path", description="comment id", required=true, @OA\Schema(description="comment id", type="integer",)),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=400, description="Invalid request")
     *  )
     */
    public function delete(Comments $comment)
    {
        $this->commentsService->delete($comment->id);
        return response()->json('success');
    }

    /**
     * @param Request $request
     * @return ResourceCollection
     *
     * @OA\Get (
     *     path="/comments/search",
     *     summary="Search comments by string",
     *     tags={"Comment"},
     *     @OA\Parameter(name="search", in="query", description="search query", required=true, @OA\Schema(description="search query", type="integer",)),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function search(Request $request): ResourceCollection
    {
        $comments = $this->searchService->searchComments($request->get('search'));
        return $comments->toResourceCollection();
    }
}
