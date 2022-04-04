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
        return view('create');
    }

    public function store(Request $request)
    {
        $posts=$request->all();
        $request->validate(['content'=>'required']);

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

        return view('edit',compact('edit_post','included_tags'));
    }

    public function update(Request $request)
    {
        $posts=$request->all();
        $request->validate(['content'=>'required']);

        Post::where('id','=',$posts['post_id'])
        ->update(['content' => $posts['content']]);

        PostTag::where('post_id','=',$posts['post_id'])->delete();
        
        if(!empty($posts['tags'][0])){
            foreach($posts['tags'] as $tag){
                PostTag::insert(['post_id' => $posts['post_id'], 'tag_id' => $tag]);
            }
        }

        return redirect(route('home'));
    }

    public function destroy(Request $request)
    {
        $posts = $request->all();

        Post::where('id','=',$posts['post_id'])
        ->update(['deleted_at' => date('Y-m-d H:i:s',time())]);
        
        
        return redirect(route('home'));
    }
}
