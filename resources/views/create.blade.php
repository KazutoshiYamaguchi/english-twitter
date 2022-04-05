@extends('layouts.app')

@section('content')
<div class="card my-card-body p-3">
    <form class="form-group" action='{{route('store')}}' method="post">
        @csrf
        <textarea class="form-control mb-3" name='content' placeholder="Share your great experience" rows="5"></textarea>
        @error('content')
        <div class="alert alert-danger">Oops! Enter your wonderful tweet.</div>
        @enderror
        <p class="text-secondary">Add hashtags?</p>
        @foreach($tags as $tag)
            <div class="form-check form-check-inline mb-3">
              <input class="form-check-input" type="checkbox" name="tags[]" id="{{ $tag['id'] }}" value="{{ $tag['id'] }}">
              <label class="form-check-label" for="{{ $tag['id'] }}">{{ $tag['name']}}</label>
            </div>
        @endforeach
        
        <div class="dropdown-divider"></div>
        
        <div class="d-flex justify-content-end pb-2 pr-1">
            <button type="submit" class="btn btn-primary">tweet</button>
        </div>
        
    </form>
</div>
@endsection
