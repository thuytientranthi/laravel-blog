<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->get();
        return $posts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->file;
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'content' => 'required',
            'description' => 'required',
            // 'image' => 'required|mimes:jpeg,jpg,png',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => [
                    $validator->errors()->first('title'),
                    $validator->errors()->first('content'),
                    $validator->errors()->first('description'),
                    // $validator->errors()->first('image'),
                ],
                'status' => 400
            ]);
        }
        try {
            if($request->get('image'))
            {
                $image = $request->get('image');
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($request->get('image'))->save(public_path('images/').$name);
            }
            $post = New Post;
            $post->title        = $request->title;
            $post->slug         = str_slug($request->title);
            $post->content      = $request->content;
            $post->description  = $request->description;
            $post->image        = $name;
            $post->save();
            return $post;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if($request->get('image'))
            {
                $image = $request->get('image');
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($request->get('image'))->save(public_path('images/').$name);
            }
            $post = Post::findOrFail($id);
            $post->title        = $request->title;
            $post->slug         = str_slug($request->title);
            $post->content      = $request->content;
            $post->description  = $request->description;
            $post->image        = $name;
            $post->save();
            return $post;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return "success";
    }
}
