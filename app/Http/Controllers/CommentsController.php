<?php

namespace App\Http\Controllers;

use App\Events\CommentCreated;
use App\Models\Comments;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;


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
    /**
     * @param Request $request
     * @return JsonResponse
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
    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'comment_text' => 'required|string',
            'news_id' => 'required|integer|exists:news,id',
        ]);

        try {
            $comment = Comments::create($data);
            CommentCreated::dispatch($comment);
        } catch (\Exception $exception) {
            //todo add log
            return response()->json('something went wrong', 500);
        }

        return response()->json($comment->toJson());
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
    public function update(Comments $comment, Request $request): JsonResponse
    {
        Gate::allowIf(function (User $user) use ($comment) {
            return $comment->isOwnedBy($user);
        });

        $data = $request->validate([
            'comment_text' => 'required|string',
            'news_id' => 'required|integer|exists:news,id',
        ]);

        try {
            $comment->update($data);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }

        return response()->json($comment->toJson());
    }

    /**
     * @param Comments $comment
     * @return JsonResponse
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
    public function getById(Comments $comment): JsonResponse
    {
        return response()->json($comment->toJson());
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
    public function getByNewsId(News $news): JsonResponse
    {
        return response()->json(
            Comments::where('news_id', '=', $news->id)
                ->get(['id', 'comment_text'])
        );
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
        Gate::allowIf(function (User $user) use ($comment) {
            return $comment->isOwnedBy($user);
        });

        $comment->delete();
        return response()->json('success');
    }

    /**
     * @param Request $request
     * @return JsonResponse
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
    public function search(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $comments = Comments::whereLike('comment_text', '%' . $search . '%')->get();
        return response()->json($comments);
    }
}
