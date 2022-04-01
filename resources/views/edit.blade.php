@extends('layouts.app')

@section('content')

<div class='card'>
    <form class="form-group" action='{{route('update')}}' method="post">
        @csrf
        <input type="hidden" name='post_id' value='{{$edit_post['id']}}'>
        <textarea class="form-control mb-3" name='content' placeholder="edit here.." rows="3">{{$edit_post['content']}}</textarea>

        <p class="text-secondary">Add hashtags?</p>
        @foreach($tags as $tag)
          <div class="form-check form-check-inline mb-3">
            <input class="form-check-input" type="checkbox" name="tags[]" 
            id="{{ $tag['id'] }}" value="{{ $tag['id'] }}" {{ in_array($tag['id'] , $included_tags) ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $tag['id'] }}">{{ $tag['name']}}</label>
          </div>
        @endforeach

        <button type="submit" class="btn btn-primary">edit</button>
    </form>
    <form class="form-group" action='{{route('destroy')}}' method="post">
        @csrf
        <input type="hidden" name='post_id' value='{{$edit_post['id']}}'>
        <button type="submit" class="btn btn-danger">delete</button>
    </form>
</div>

@endsection
