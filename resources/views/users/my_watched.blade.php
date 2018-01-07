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
                    <div class="panel-heading" data-toggle="collapse" data-target="#collapse{{ $myEpisode->id }}" aria-expanded="false" aria-controls="collapse{{ $myEpisode->id }}">
                        <h4><strong>{{ $myEpisode->name }}</strong></h4>
                        <h5><a href="{{ url('/show/' . $myEpisode->show_id) }}">{{ $myEpisode->getShow($myEpisode->show_id) }}</a> - S{{ $myEpisode->season }} x E{{ $myEpisode->number }}</h5>
                    </div>

                    <div class="panel-body episodeDetail collapse" id="collapse{{ $myEpisode->id }}">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 np">
                            <img src={{ $myEpisode->image }}>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                            <p>{{ $myEpisode->synopsis }}</p>
                            @if (Auth::check())
                            <p><strong>Your actions:</strong>
                                <watched
                                    :episode={{ $myEpisode->id }}
                                    :user={{ Auth::user()->id }}
                                ></watched>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p>You have not watched any episodes.</p>
            @endforelse
         </div>
    </div>
</div>
@endsection