<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBlogPostRequest;
use App\Models\BlogPost;
use Illuminate\Validation\UnauthorizedException;

class BlogPostController extends Controller
{
    public function index()
    {
        $data = BlogPost::all();
        // return response()->json(BlogPost::all());
        return $this->successResponse($data);
    }

    public function store(CreateBlogPostRequest $request)
    {
        $data = $request->only(['title', 'body']);

        $user_id = 1;
        $data['user_id'] = $user_id;
        $blog_post  = BlogPost::create($data);

        // $user  = auth()->user();
        // $blog_post = $user->blogPosts()->create($data);

        return $this->successResponse($blog_post);
    }

    public function show(BlogPost $blogPost)
    {
        return $this->successResponse($blogPost);
    }

    public function update(BlogPost $blogPost, CreateBlogPostRequest $request)
    {
        $data = $request->only(['title', 'body']);
        $blogPost->update($data);
        return $this->successResponse($blogPost);
    }

    public function destroy(BlogPost $blogPost)
    {
        // if(auth()->user()->id !== $blogPost->user_id){
        //     throw new UnauthorizedException();
        // }

        $blogPost->delete();


        return $this->successResponse(
            ["message" => "deleted successfully"]
        );
    }
}
