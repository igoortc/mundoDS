@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h3>All Shows</h3>
            </div>
            @forelse ($shows as $show)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-md-3 col-3 poster">
                                <img src={{ $show->poster }}>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9 showInfo">
                                <a href="{{ url('show') }}/{{ $show->id }}"><p>{{ $show->name }}</p></a>
                                <div class="showDetail">
                                    <span>{{ $show->seasons }} temporadas | </span>
                                    @if ($show->netflix != '')
                                    <a target="_blank" href={{ $show->netflix }}>
                                        <img alt="Netflix" src="https://assets.cdn.moviepilot.de/files/moviepilot/logos/netflix-archive.png/fill/16/16/netflix-archive.png">
                                    </a>
                                    @else
                                    <img class="unavailable" alt="Netflix" src="https://assets.cdn.moviepilot.de/files/moviepilot/logos/netflix-archive.png/fill/16/16/netflix-archive.png">
                                    @endif
                                    &nbsp;
                                    @if ($show->imdb != '')
                                    <a target="_blank" href={{ $show->imdb }}>
                                        <img alt="IMDb" src="https://250.took.nl/img/icon_imdb.png">
                                    </a>
                                    @else
                                    <img class="unavailable" alt="IMDb" src="https://250.took.nl/img/icon_imdb.png">
                                    @endif
                                </div>
                                <p>{{ $show->synopsis }}</p>
                                @if (Auth::check())
                                    <favorite
                                        :show={{ $show->id }}
                                        :favorited={{ $show->favorited() ? 'true' : 'false' }}
                                    ></favorite>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No show created.</p>
            @endforelse

           {{ $shows->links() }}
        </div>
    </div>
</div>
@endsection
