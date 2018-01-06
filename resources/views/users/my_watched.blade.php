@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h3>My Watched Episodes</h3>
            </div>
            @forelse ($myWatched as $myEpisode)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><strong>{{ $myEpisode->name }}</strong></h4>
                        <a href="{{ url('/show/' . $myEpisode->show_id) }}">{{ $myEpisode->getShow($myEpisode->show_id) }}</a> - S{{ $myEpisode->season }} x E{{ $myEpisode->number }}
                    </div>

                    <div class="panel-body">
                        <blockquote>{{ $myEpisode->synopsis }}</blockquote>
                    </div>
                    @if (Auth::check())
                        <div class="panel-footer">
                            <watched
                                :episode={{ $myEpisode->id }}
                                :watched={{ $myEpisode->watched() ? 'true' : 'false' }}
                            ></watched>
                        </div>
                    @endif
                </div>
            @empty
                <p>You have not watched any episodes.</p>
            @endforelse
         </div>
    </div>
</div>
@endsection