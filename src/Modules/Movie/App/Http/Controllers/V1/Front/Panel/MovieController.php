<?php

namespace Modules\Movie\App\Http\Controllers\V1\Front\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Modules\Movie\App\Http\Requests\V1\Front\UpdateMovieRequest;
use Modules\Movie\App\Repositories\V1\Contracts\MovieRepositoryContract;
use Modules\Movie\App\resources\V1\Front\MovieResource;
use Modules\Movie\App\Http\Requests\V1\Front\CreateMovieRequest;
use Modules\Movie\App\Models\Movie;
use Modules\Movie\App\Services\V1\Contracts\MovieServiceContract;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MovieController extends Controller
{
    public function __construct(private readonly MovieServiceContract    $movieServiceContract,
                                private readonly MovieRepositoryContract $movieRepositoryContract)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/v1/panel/movies",
     *     tags={"Movies"},
     *     summary="List all movies",
     *     description="Retrieve a list of all movies.",
     *     operationId="listMovies",
     *     @OA\Response(
     *         response=200,
     *         description="List of movies retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Success"),
     *             @OA\Property(property="data", type="array", @OA\Items())
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Fail"),
     *             @OA\Property(property="message", type="string", example="Internal server error message")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            DB::beginTransaction();
            $movies = $this->movieRepositoryContract->all();
            DB::commit();
            return response()->json([
                'status' => Lang::get('custom_messages.success'),
                'data' => MovieResource::collection($movies)
            ], ResponseAlias::HTTP_OK);

        } catch (\Exception $exception) {
            Log::error(route('front.panel.movies.index'), [
                __FILE__ => $exception->getMessage()]);

            return response()->json([
                'status' => Lang::get('custom_messages.fail'),
                'message' => $exception->getMessage(),
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateMovieRequest $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/v1/panel/movies",
     *     tags={"Movies"},
     *     summary="Store a new movie",
     *     description="Store a new movie with the given details.",
     *     operationId="storeMovie",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Movie data",
     *         @OA\JsonContent(
     *             required={"title", "description", "price", "video", "thumbnail"},
     *             @OA\Property(property="title", type="string", example="Movie Title"),
     *             @OA\Property(property="description", type="string", example="Movie Description"),
     *             @OA\Property(property="price", type="number", format="float", example=10.99),
     *             @OA\Property(property="imdb_id", type="string", example="tt1234567"),
     *             @OA\Property(property="imdb_thumbnail", type="string", example="https://example.com/image.jpg"),
     *             @OA\Property(property="imdb_rating", type="number", format="float", example=7.5),
     *             @OA\Property(property="video", type="string", format="binary", description="Video file (required)"),
     *             @OA\Property(property="thumbnail", type="string", format="binary", description="Thumbnail image file (required)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Movie created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Success"),
     *             @OA\Property(property="message", type="string", example="Movie created successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Fail"),
     *             @OA\Property(property="message", type="string", example="Internal server error message")
     *         )
     *     )
     * )
     */
    public function store(CreateMovieRequest $request)
    {
//        try {
//            DB::beginTransaction();
            $movie = $this->movieServiceContract->store($request);
//            DB::commit();
//            return response()->json([
//                'status' => Lang::get('custom_messages.success'),
//                'message' => Lang::get('custom_messages.create_success'),
//                'data' => MovieResource::make($movie->load('thumbnail', 'video'))
//            ], ResponseAlias::HTTP_CREATED);

//        } catch (\Exception $exception) {
//            Log::error(route('front.panel.movies.store'), [
//                __FILE__ => $exception->getMessage()]);
//
//            DB::rollBack();
//            return response()->json([
//                'status' => Lang::get('custom_messages.fail'),
//                'message' => $exception->getMessage(),
//            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
//        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Movie $movie
     * @param UpdateMovieRequest $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/v1/panel/movies/{movie}",
     *     tags={"Movies"},
     *     summary="Update a movie",
     *     description="Update the movie with the given details.",
     *     operationId="updateMovie",
     *     @OA\Parameter(
     *         name="movie",
     *         in="path",
     *         description="ID of the movie to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Movie data",
     *         @OA\JsonContent(
     *             required={"title", "description", "price"},
     *             @OA\Property(property="title", type="string", example="Updated Movie Title"),
     *             @OA\Property(property="description", type="string", example="Updated Movie Description"),
     *             @OA\Property(property="price", type="number", format="float", example=12.99),
     *             @OA\Property(property="imdb_id", type="string", example="tt9876543"),
     *             @OA\Property(property="imdb_thumbnail", type="string", example="https://example.com/updated_image.jpg"),
     *             @OA\Property(property="imdb_rating", type="number", format="float", example=8.0),
     *             @OA\Property(property="video", type="string", format="binary", description="Updated video file"),
     *             @OA\Property(property="thumbnail", type="string", format="binary", description="Updated thumbnail image file")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movie updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Success"),
     *             @OA\Property(property="message", type="string", example="Movie updated successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Fail"),
     *             @OA\Property(property="message", type="string", example="Internal server error message")
     *         )
     *     )
     * )
     */
    public function update(Movie $movie, UpdateMovieRequest $request)
    {
        try {
            DB::beginTransaction();
            $movie = $this->movieServiceContract->update($movie, $request);
            DB::commit();
            return response()->json([
                'status' => Lang::get('custom_messages.success'),
                'message' => Lang::get('custom_messages.update_success'),
                'data' => MovieResource::make($movie->load('thumbnail', 'video'))
            ], ResponseAlias::HTTP_OK);

        } catch (\Exception $exception) {
            Log::error(route('front.panel.movies.update'), [
                __FILE__ => $exception->getMessage()]);

            DB::rollBack();
            return response()->json([
                'status' => Lang::get('custom_messages.fail'),
                'message' => $exception->getMessage(),
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
