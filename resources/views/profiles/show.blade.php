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

                @foreach($activities as $date => $activitys)
                    <h3 class="page-header">{{ $date }}</h3>
                    @foreach ($activitys as $activity)
                        @include ("profiles.activities.{$activity->type}")
                    @endforeach
                @endforeach

                {{--{{ $threads->links() }}--}}
            </div>
        </div>

    </div>
@endsection