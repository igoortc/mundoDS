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
                        <h4><a href="{{ url('/show/' . $myEpisode->show_id) . '/episode/' . $myEpisode->id }}"><strong>{{ $myEpisode->name }}</strong></a></h4>
                        <h5><a href="{{ url('/show/' . $myEpisode->show_id) }}">{{ $myEpisode->getShow($myEpisode->show_id) }}</a> - S{{ $myEpisode->season }} x E{{ $myEpisode->number }}</h5>
                        @if (Auth::check())
                            <p><strong>My actions:</strong>
                                <watched
                                    :episode={{ $myEpisode->id }}
                                    :user={{ Auth::user()->id }}
                                ></watched>
                            </p>
                        @endif
                    </div>
                </div>
            @empty
                <p>You have not watched any episodes.</p>
            @endforelse
            {{ $myWatched->links() }}
         </div>
    </div>
</div>
@endsection