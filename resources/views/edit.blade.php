@extends('layouts.app')

@section('javascript')
<script src="/js/confirm.js"></script>
@endsection

@section('content')
<div class='card my-card-body p-3'>
    
    <div class="card-header">
        Edit your tweet
        <form class="form-group d-flex justify-content-end" id='delete-form' action='{{route('destroy')}}' method="post">
            @csrf
            <input type="hidden" name='post_id' value='{{$edit_post[0]['id']}}'>
            <i data-toggle="tooltip" data-placement="top" title="Delete this post?" type="button" class="fas fa-trash" style="color: #cc2e12" onclick="deleteHandle(event)"></i>
        </form>
    </div>
    <form class="form-group" action='{{route('update')}}' method="post">
        @csrf
        <input type="hidden" name='post_id' value='{{$edit_post[0]['id']}}'>
        <textarea class="form-control mb-3" name='content' placeholder="edit here.." rows="5" autofocus>{{$edit_post[0]['content']}}</textarea>
        @error('content')
        <div class="alert alert-danger">Oops! Enter your wonderful tweet.</div>
        @enderror

        <span class="text-secondary">Add hashtags?</span>
        @foreach($tags as $tag)
          <div class="form-check form-check-inline mb-3">
            <input class="form-check-input" type="checkbox" name="tags[]" 
            id="{{ $tag['id'] }}" value="{{ $tag['id'] }}" {{ in_array($tag['id'] , $included_tags) ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $tag['id'] }}">{{ $tag['name']}}</label>
          </div>
        @endforeach
        <div class="dropdown-divider"></div>
        <div class="d-flex justify-content-end pb-2 pr-1">
        <button type="submit" class="btn btn-primary">edit</button>
        </div>
        </form>
</div>

@endsection
