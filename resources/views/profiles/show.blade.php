@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">
                    <h1>
                        {{ $profileUser->name }}
                        <small>Joined {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>
                </div>

                @foreach($threads as $thread)
                    <div class="panel panel-default">
                        <div class="panel-heading">Forum Threads</div>
                        <div class="list-group">
                            <a href="{{$thread->path() }}" class="list-group-item">{{$thread->title}}</a>
                        </div>
                    </div>
                @endforeach

                {{ $threads->links() }}
            </div>
        </div>

    </div>
@endsection