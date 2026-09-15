<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return PostResource::collection(Post::all());
        // return PostResource::collection(Post::with('user')->paginate(2));

        $user = request()->user();
        // $user = Auth::user();
        $post = $user->posts()->paginate();
        //  $post = $user->posts()->paginate(request()->query('per_page', 15 ));
        return PostResource::collection($post);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        // $data = $request->only(['title']);
        // return $data;
        // return response()->json([
        //     "data" => [
        //         "id" => 1,
        //         "title" => $request->title,
        //         "content" => $request->content
        //     ],
        //     "message" => "Post created successfully"
        // ], 201);
        $data["user_id"] = Auth::user()->id; 
        $post = Post::create($data);
        return response()->json(new PostResource($post), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $user = request()->user();
        // if($user->id != $post->user_id){
        //     abort(403, 'Access Denied');
        // }

        abort_if(Auth::id() != $post->user_id, 403, 'Access Denied');
        // return [
        //     "data" => [
        //         "id" => $id,
        //         "title" => "Post Title",
        //         "content" => "Post Content"
        //     ],
        //     "message" => "Post retrieved successfully",
        //     "others" => [
        //         "author" => "John Doe",
        //         "published_at" => "2024-06-01 12:00:00"
        //     ]
        // ];

        // return response()->json([
        //     "data" => [
        //         "id" => $id,
        //         "title" => "Post Title",
        //         "content" => "Post Content"
        //     ],
        //     "message" => "Post retrieved successfully",
        //     "others" => [
        //         "author" => "John Doe",
        //         "published_at" => "2024-06-01 12:00:00"
        //     ]
        // ], 201)->header('New-Header', 'CustomValue');

        // return response()->json([
        //     $post
        // ], 201)->header('New-Header', 'CustomValue');
        return response()->json( new PostResource($post), 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        abort_if(Auth::id() != $post->user_id, 403, 'Access Denied');
        $data = $request->validate([
            "title" => "required|string|max:255",
            "body" => "required|string"
        ]);

        $post->update($data);
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        abort_if(Auth::id() != $post->user_id, 403, 'Access Denied');
        $post->delete();
        return response()->noContent();
    }
}
