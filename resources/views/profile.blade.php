@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-1">
            <img src="{{asset('storage/'.$user->image) }}" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
            <h2>{{ $user->name }}</h2>
            <form enctype="multipart/form-data" method="POST">
                <input type="file" name="avatar">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="pull-right btn btn-sm btn-primary" value="Submit">
            </form>
            <h4 class="mt-3">{{sizeof($posts)}} Posts</h4>

        </div>
    </div>
    <hr>
        <div class="row">
            @foreach ($posts as $post)
            @php
                $user = App\Models\User::where('_id', $post->created_by)->first();
            @endphp
            <div class="card mr-5 mb-5" style="width: 20rem;">
                <div class="mt-2 col-md-12">
                    <img src="{{asset('storage/'.$user->image)}}" style="width:50px; height:50px; border-radius:50%;" alt="profile picture">
                    <b>{{$user->name}}</b>
                    @if($user->_id == \Auth::user()->_id)
                        <div class="dropdown float-right mt-2">
                            <button class="btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            More
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route('post.form',$post->_id)}}">Edit</a>
                            <a class="dropdown-item" href="{{route('post.delete', $post->_id)}}">Delete</a>
                            </div>
                        </div>
                    @endif
                </div>
                <hr>
                <h5 class="card-title text-center">{{$post->title}}</h5>
                <img class="card-img-top" width="18rem" height="320rem" src="{{asset('storage/'.$post->image)}}" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text">{{$post->content}}</p>
                  <hr>
                  <a class="btn btn-{{in_array(\Auth::user()->_id, $post->likes) ? "success":"primary"}}" href="{{ route('like', $post->_id) }}?route=profile"><span class="font-weight-bold mr-2">{{sizeof($post->likes)}} </span><i class="fa fa-thumbs-up"> Like</i> </a>

                </div>
            </div>
            @endforeach
        </div>

</div>
@endsection
