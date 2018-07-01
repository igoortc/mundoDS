@extends('layouts.app')

@section('content')
<div class="page-wrap">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h3>My Watched Episodes</h3>
            </div>
            @forelse ($myWatched as $myEpisode)
                <div class="panel panel-default searchResults">
                    <div class="panel-body">
                        <div class="col-md-3 col-xs-3 poster">
                            <img src={{ $myEpisode->image }}>
                        </div>
                        <div class="col-md-9 col-xs-9 showInfo">
                            <p><a href="{{ url('/show/' . $myEpisode->show_id) . '/episode/' . $myEpisode->id }}">{{ $myEpisode->name }}</a></p>
                            <h5><a href="{{ url('/show/' . $myEpisode->show_id) }}">{{ $myEpisode->getShow($myEpisode->show_id) }}</a> - S{{ $myEpisode->season }} x E{{ $myEpisode->number }}</h5>
                            @if (Auth::check())
                                <p><strong>My actions:</strong>
                                    <p><watched
                                        :episode={{ $myEpisode->id }}
                                        :user={{ Auth::user()->id }}
                                    /></p>
                                </p>
                            @endif
                        </div>
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