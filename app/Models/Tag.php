<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function getTags(){
        $tags=Tag::select('tags.*')
        ->whereNull('deleted_at')
        ->orderby('id','asc')
        ->get();

        return $tags;
    }

    public function getSelectedTag(){
        $query_tag = \Request::query('tag');

        if(!empty($query_tag)){
            $selectedTag=Tag::select('tags.*')
            ->where('id','=',$query_tag)
            ->whereNull('deleted_at')
            ->get();
            return $selectedTag;
        }
        return null;
    }
}
