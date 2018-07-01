@extends('layouts.app')
@section('content')
<div class="page-wrap">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3>Search results for <em>{{ $search }}</em></h3>
            <b-tabs class="opacity-1 mb-10 searchResults">
                <b-tab title="Shows" active>
                    @forelse ($searchShows as $show)
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3 col-xs-3 poster">
                                        <img src={{ $show->poster }}>
                                    </div>
                                    <div class="col-md-9 col-xs-9 showInfo">
                                        <a href="{{ url('show') }}/{{ $show->id }}"><p>{{ $show->name }}</p></a>
                                        @if (Auth::check())
                                            <favorite
                                                :show={{ $show->id }}
                                                :favorited={{ $show->favorited() ? 'true' : 'false' }}
                                            ></favorite>
                                        @endif
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
                                        <p><i class="fa fa-quote-left"></i> {{ $show->synopsis }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No shows found.</p>
                    @endforelse
                    {{ $searchShows->links() }}
                </b-tab>
                <b-tab title="Users">
                    @forelse ($searchUsers as $user)
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3 col-xs-3 poster">
                                        <img src={{ $user->photo }}>
                                    </div>
                                    <div class="col-md-9 col-xs-9 showInfo">
                                        @if (Auth::user()->id == $user->id)
                                            <a href="{{ url('my_profile') }}"><p>{{ $user->name }}</p></a>
                                        @else
                                            <a href="{{ url('user') }}/{{ $user->id }}"><p>{{ $user->name }}</p></a>
                                        @endif
                                        <p><i class="fa fa-quote-left"></i> {{ $user->bio }}</p>
                                        @if (Auth::user()->id != $user->id)
                                            <p>
                                                <follow
                                                    :user_id={{ $user->id }}
                                                    :following_id={{ $user->followed() ? 'true' : 'false' }} />
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No users found.</p>
                    @endforelse
                    {{ $searchUsers->links() }}
                </b-tab>
            </b-tabs>
        </div>
    </div>
</div>
@endsection