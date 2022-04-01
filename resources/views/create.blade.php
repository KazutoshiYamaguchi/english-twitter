@extends('layouts.app')

@section('content')
<form class="form-group" action='{{route('store')}}' method="post">
    @csrf
    <textarea class="form-control mb-3" name='content' placeholder="tweet here.." rows="3"></textarea>

    <p class="text-secondary">Add hashtags?</p>
    @foreach($tags as $tag)
        <div class="form-check form-check-inline mb-3">
          <input class="form-check-input" type="checkbox" name="tags[]" id="{{ $tag['id'] }}" value="{{ $tag['id'] }}">
          <label class="form-check-label" for="{{ $tag['id'] }}">{{ $tag['name']}}</label>
        </div>
    @endforeach

    <button type="submit" class="btn btn-primary">tweet</button>
</form>
@endsection
