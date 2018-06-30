@extends('layouts.app')

@section('content')
<div class="page-wrap">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h3>My Favorite Shows</h3>
            </div>
            @forelse ($myFavorites as $myFavorite)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3 col-md-3 poster">
                                <img src={{ $myFavorite->poster }}>
                            </div>
                            <div class="col-sm-9 col-md-9 showInfo">
                                <a href="{{ url('show') }}/{{ $myFavorite->id }}"><p>{{ $myFavorite->name }}</p></a>
                                <div class="showDetail">
                                    <span>{{ $myFavorite->seasons }} seasons | </span>
                                    @if ($myFavorite->status == 'E')
                                    <span><i class="fa fa-television"></i> On air | </span>
                                    @elseif ($myFavorite->status == 'F')
                                    <span><i class="fa fa-paper-plane-o"></i> Finished | </span>
                                    @elseif ($myFavorite->status == 'W')
                                    <span><i class="fa fa-hand-paper-o"></i> To be released | </span>
                                    @elseif ($myFavorite->status == 'B')
                                    <span><i class="fa fa-fa-rocket"></i> Binge | </span>
                                    @endif
                                    @if ($myFavorite->netflix != '')
                                    <a target="_blank" href={{ $myFavorite->netflix }}>
                                        <img alt="Netflix" src="/images/netflix.png">
                                    </a>
                                    @else
                                    <img class="unavailable" alt="Netflix" src="/images/netflix.png">
                                    @endif
                                    &nbsp;
                                    @if ($myFavorite->imdb != '')
                                    <a target="_blank" href={{ $myFavorite->imdb }}>
                                        <img alt="IMDb" src="/images/imdb.png">
                                    </a>
                                    @else
                                    <img class="unavailable" alt="IMDb" src="/images/imdb.png">
                                    @endif
                                </div>
                                <p>{{ $myFavorite->synopsis }}</p>
                                @if (Auth::check())
                                    <favorite
                                        :show={{ $myFavorite->id }}
                                        :favorited={{ $myFavorite->favorited() ? 'true' : 'false' }}
                                    ></favorite>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No show created.</p>
            @endforelse
            {{ $myFavorites->links() }}
         </div>
    </div>
</div>
@endsection