<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\PostTag;
use App\Models\Reply;

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
            toastr()->success('Tweeted successfully!');
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

    public function reply($id)
    {
        $reply_post = Post::select('posts.*','name as username')
            ->leftjoin('users','users.id','=','posts.user_id')
            ->where('posts.id', '=', $id)
            ->whereNull('posts.deleted_at')
            ->get();
        
        $replies = Reply::select('replies.*','name as username')
        ->leftjoin('users','users.id','=','replies.user_id')
        ->where('replies.post_id', '=', $id)
        ->orderby('replies.updated_at','desc')
        ->whereNull('replies.deleted_at')
        ->get();

        return view('reply',compact('reply_post','replies'));
    }

    public function storeReplies(Request $request)
    {
        $posts = $request->all();
        $request->validate(['content'=>'required']);
        $post_id = $posts['post_id'];

        DB::transaction(function () use($posts) {
            Reply::insert(['reply_content' => $posts['content'],'post_id'=>$posts['post_id'],'user_id'=> \Auth::id()]);

            toastr()->success('Your reply was sent!');
        });
 
        return redirect(route('reply',$post_id));
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
        toastr()->success('Your tweet was changed!');

        return redirect(route('home'));
    }

    public function destroy(Request $request)
    {
        $posts = $request->all();

        Post::where('id','=',$posts['post_id'])
        ->update(['deleted_at' => date('Y-m-d H:i:s',time())]);

        toastr()->success('Your tweet was deleted!');
        
        
        return redirect(route('home'));
    }

    public function replyDestroy(Request $request)
    {
        
        $posts = $request->all();
    
        $post_id = $posts['post_id'];
        $reply_id = $posts['reply_id'];

        Reply::where('id','=',$posts['reply_id'])
        ->update(['deleted_at' => date('Y-m-d H:i:s',time())]);

        toastr()->success('Your reply was deleted!');
        
        return redirect(route('reply',$post_id));
    }
    
    
}
