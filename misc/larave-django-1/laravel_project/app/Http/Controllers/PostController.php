<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class PostController extends Controller
{

    public function index(): View
    {
        $postsCollection = Post::orderBy('id', 'desc')->paginate(5);
        return view('web.posts.index', ['postsCollection' => $postsCollection]);
    }


    public function store(PostRequest $request): RedirectResponse
    {
//        $this->validate($request, [
//            'title' => 'required|max:255',
//            'slug' => 'required|unique:posts,slug',
//            'content' => 'required',
//        ]);
//        dd($request);

//        Post::create($request->all());

//         $post = new Post;
//         $post->title = $request->title;
//         $post->slug = $request->slug;
//         $post->excerpt = $request->excerpt;
//         $post->content = $request->content;
//         $post->saveOrFail();

         $post = new Post;
         $post->title = $request->input('title');
         $post->slug = $request->input('slug');
         $post->excerpt = $request->input('excerpt');
         $post->content = $request->input('content');
         $post->saveOrFail();

//         $post = new Post;
//         $post->title = $request['title'];
//         $post->slug = $request['slug'];
//         $post->excerpt = $request['excerpt'];
//         $post->content = $request['content'];
//         $post->saveOrFail();

//         Mail::send(new NewPost($post));

        return back()->with('success', 'The post was created');
    }


    public function show(Post $post)
    {
        //
    }


    public function edit(Post $post): View
    {
        $postsCollection = Post::orderBy('id', 'desc')->paginate(5);

        return view('web.posts.edit', ['post' => $post, 'postsCollection' => $postsCollection]);
    }


    public function update(PostUpdateRequest $request, Post $post): RedirectResponse
    {


        $post->update($request->all());

//        $post->title = $request['title'];
//        $post->slug = $request['slug'];
//        $post->excerpt = $request['excerpt'];
//        $post->content = $request['content'];
//        $post->saveOrFail();

        return back()->with('success', 'The post has been successfully updated');
    }


    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('posts.index');
        // return redirect()->back();
    }

}
