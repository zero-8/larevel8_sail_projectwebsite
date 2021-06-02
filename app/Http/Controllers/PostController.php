<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Ckeditorupload;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $time_start = microtime(true);
        $time_end = microtime(true);
        $timeend = $time_end - $time_start;

        return response()->json([
            'success' => true,
            '_elapsed_time' => $timeend,
            $request->user()
            // 'errors' => $validator->errors(),
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $user = User::findOrFail($request->user()->id);

        $newpost = new Post(
            [
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'slug' => Str::slug($request->input('title')."-".time() , '-')
            ]
        );

        $user->posts()->save($newpost);

        $time_start = microtime(true);
        $time_end = microtime(true);
        $timeend = $time_end - $time_start;

        return response()->json([
            'success' => true,
            '_elapsed_time' => $timeend,
            'user' => $request->user(),
            'user_id' => $request->user()->id,
            'data' => $request->input('name')

        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $user = User::findOrFail($id);

        foreach ($user->posts as $post) {

            echo $post->title . " " . $post->content . '<br/>';
        }
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
    public function update(Request $request, $user_id, $post_id)
    {

        // var_dump($user_id);
        // echo '<br>';
        // var_dump($post_id);
        // die();
        $user = User::findOrFail($user_id);

        $user->posts()->whereId($post_id)->update(['title' => 'my title', 'content' => 'my content']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $post_id)
    {

        // $datum  = FaqFile::find($id);
        // $datum->delete();

        $user = User::findOrFail($user_id);

        $user->posts()->whereId($post_id)->delete();
    }


    public function ckeditor(Request $request)
    {


        $filenameWithExt = $request->file('upload')->getClientOriginalName();

        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        $extension = $request->file('upload')->getClientOriginalExtension();

        $FileNameToStore = $filename . '_' . time() . "." . $extension;

        $path = $request->file('upload')->storeAs('public/upload_ckeditor', $FileNameToStore);

        $data["domain"] = $_SERVER['SERVER_NAME'];
        $FileNameToStore = 'storage/upload_ckeditor/' . $FileNameToStore;

        $mydata["ret"] =  $filenameWithExt;

        $image_log = new Ckeditorupload;
        $image_log->user_id= $request->user()->id;
        $image_log->image_name = $path;
        $image_log->save();


        return response()->json([
            'data' => $request,
            'user' => $request->user(),
            'success' => 1,
            'path' => $path,
            'url' =>  $mydata["url"] =  url($FileNameToStore)
        ], 200);


    }
}
