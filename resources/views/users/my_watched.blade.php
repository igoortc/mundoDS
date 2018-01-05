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
                        {{ $myEpisode->name }}
                    </div>

                    <div class="panel-body">
                        {{ $myEpisode->season }} x {{ $myEpisode->number }}
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