<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function getPosts(){
        $query_tag = \Request::query('tag');
        $query = Post::query()->select('posts.*','users.name as username')
        ->leftjoin('users','users.id','=','posts.user_id')
        ->whereNull('posts.deleted_at')
        ->orderBy('posts.updated_at', 'DESC');

        if(!empty($query_tag)){
            $query->leftjoin('post_tags','posts.id','=','post_tags.post_id')
            ->where('post_tags.tag_id','=',$query_tag);
        }

        $posts = $query->get();
        

        return $posts;
    }

    
}
