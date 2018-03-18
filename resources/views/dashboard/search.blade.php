@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h3>Search results for <em>{{ $search }}</em></h3>
                <h3>Shows</h3>
            </div>
            @forelse ($searchShows as $show)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 poster">
                                <img src={{ $show->poster }}>
                            </div>
                            <div class="col-md-9 showInfo">
                                <a href="{{ url('show') }}/{{ $show->id }}"><p>{{ $show->name }}</p></a>
                                <div class="showDetail">
                                    <span>{{ $show->seasons }} seasons | </span>
                                    @if ($show->status == 'E')
                                    <span><i class="fa fa-television"></i> On air | </span>
                                    @elseif ($show->status == 'F')
                                    <span><i class="fa fa-paper-plane-o"></i> Finished | </span>
                                    @elseif ($show->status == 'W')
                                    <span><i class="fa fa-hand-paper-o"></i> To be released | </span>
                                    @elseif ($show->status == 'B')
                                    <span><i class="fa fa-fa-rocket"></i> Binge | </span>
                                    @endif
                                    @if ($show->netflix != '')
                                    <a target="_blank" href={{ $show->netflix }}>
                                        <img alt="Netflix" src="/images/netflix.png">
                                    </a>
                                    @else
                                    <img class="unavailable" alt="Netflix" src="/images/netflix.png">
                                    @endif
                                    &nbsp;
                                    @if ($show->imdb != '')
                                    <a target="_blank" href={{ $show->imdb }}>
                                        <img alt="IMDb" src="/images/imdb.png">
                                    </a>
                                    @else
                                    <img class="unavailable" alt="IMDb" src="/images/imdb.png">
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
                <p>No shows found.</p>
            @endforelse
            {{ $searchShows->links() }}
            <div class="page-header">
                <h3>Users</h3>
            </div>
            @forelse ($searchUsers as $user)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 poster">
                                <img src={{ $user->photo }}>
                            </div>
                            <div class="col-md-9 showInfo">
                                <a href="{{ url('user') }}/{{ $user->id }}"><p>{{ $user->name }}</p></a>
                                <p>{{ $user->bio }}</p>
                                @if (Auth::user()->id != $user->id)
                                    <follow
                                        :user_id={{ $user->id }}
                                        :following_id={{ $user->followed() ? 'true' : 'false' }}
                                    ></follow>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No users found.</p>
            @endforelse
            {{ $searchUsers->links() }}
        </div>
    </div>
</div>
@endsection