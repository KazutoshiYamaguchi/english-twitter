@extends('layouts.app')

@section('javascript')
<script src="/js/confirm.js"></script>
@endsection

@section('content')
<div class='card my-card-body p-3'>
    <form class="form-group" action='{{route('update')}}' method="post">
        @csrf
        <input type="hidden" name='post_id' value='{{$edit_post[0]['id']}}'>
        <textarea class="form-control mb-3" name='content' placeholder="edit here.." rows="3">{{$edit_post[0]['content']}}</textarea>
        @error('content')
        <div class="alert alert-danger">Oops! Enter your wonderful tweet.</div>
        @enderror

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
    
    <form class="form-group" id='delete-form' action='{{route('destroy')}}' method="post">
        @csrf
        <input type="hidden" name='post_id' value='{{$edit_post[0]['id']}}'>
        <button class="btn btn-danger" onclick="deleteHandle(event)">delete</button>
    </form>
    
</div>

@endsection
