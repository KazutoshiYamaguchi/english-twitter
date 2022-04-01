<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\PostTag;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::select('posts.*','name as username')
        ->leftjoin('users','users.id','=','posts.user_id')
        ->whereNull('deleted_at')
        ->orderby('updated_at','desc')
        ->get();

        $tags=Tag::select('tags.*')
        ->whereNull('deleted_at')
        ->orderby('id','asc')
        ->get();

        return view('create',compact('posts','tags'));
    }

    public function store(Request $request)
    {
        $posts=$request->all();

        DB::transaction(function () use($posts) {
            $post_id=Post::insertGetId(['content' => $posts['content'],'user_id'=> \Auth::id()]);

            if(!empty($posts['tags'][0])){
                foreach($posts['tags'] as $tag){
                    PostTag::insert(['post_id' => $post_id, 'tag_id' => $tag]);
                }
            }
        });
 
        return redirect(route('home'));
    }

    public function edit($id)
    {
        $posts = Post::select('posts.*','name as username')
        ->leftjoin('users','users.id','=','posts.user_id')
        ->whereNull('deleted_at')
        ->orderby('updated_at','desc')
        ->get();

        $tags=Tag::select('tags.*')
        ->whereNull('deleted_at')
        ->orderby('id','asc')
        ->get();

        $edit_post = Post::select('posts.*', 'tags.id AS tag_id')
            ->leftJoin('post_tags', 'post_tags.post_id', '=', 'posts.id')
            ->leftJoin('tags', 'post_tags.tag_id', '=', 'tags.id')
            ->where('posts.user_id', '=', \Auth::id())
            ->where('posts.id', '=', $id)
            ->whereNull('posts.deleted_at')
            ->get();
            

        $included_tags=[];
        foreach($edit_post as $post){
            array_push($included_tags,$post['tag_id']);
        }

        return view('edit',compact('posts','tags','edit_post','included_tags'));
    }

    public function update(Request $request)
    {
        $posts=$request->all();

        Post::where('id','=',$posts['post_id'])
        ->update(['content' => $posts['content']]);
        
        return redirect(route('home'));
    }

    public function destroy(Request $request)
    {
        $posts=$request->all();

        Post::where('id','=',$posts['post_id'])
        ->update(['deleted_at' => date('Y-m-d H:i:s',time())]);
        
        return redirect(route('home'));
    }
}
