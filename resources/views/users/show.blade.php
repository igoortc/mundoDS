@extends('layouts.app')

@section('content')
<div class="page-wrap">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (Auth::check())
            <div class="page-header">
                <h3>{{ $user->name }} <small>{{ $user->age->diffForHumans(null, true) }}</small> </h3>
                @if (Auth::user()->id != $user->id)
                    <follow
                        :user_id={{ $user->id }}
                        :following_id={{ $user->followed() ? 'true' : 'false' }}
                    ></follow>
                @endif
            </div>
            @if (Auth::user()->admin)
                <user-manage :user_id={{ $user->id }}></user-manage>
            @endif
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-md-3 col-3 profile">
                            <img src={{ $user-> photo }}>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
                            <p><i class="fa fa-globe"></i> {{ $user-> city }}</p>
                            <p><i class="fa fa-quote-left"></i> {{ $user-> bio }}</p>
                            <div class="analytics">
                                @if ($user->nrEpisodes($user->id) == 0)
                                    <p><i class="fa fa-list-ol"></i> {{ $user->name }} haven't watched any episodes</p>
                                @elseif ($user->nrEpisodes($user->id) == 1)
                                    <p><i class="fa fa-list-ol"></i> Watched {{ $user->nrEpisodes($user->id) }} episode</p>
                                @else
                                    <p><i class="fa fa-list-ol"></i> Watched {{ $user->nrEpisodes($user->id) }} episodes</p>
                                @endif
                                
                                @if ($user->nrRatings($user->id) == 0)
                                    <p><i class="fa fa-star-o"></i> {{ $user->name }} haven't rated any episodes</p>
                                @elseif ($user->nrRatings($user->id) == 1)
                                    <p><i class="fa fa-star-o"></i> Rated {{ $user->nrRatings($user->id) }} episode</p>
                                @else
                                    <p><i class="fa fa-star-o"></i> Rated {{ $user->nrRatings($user->id) }} episodes</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-20 col-xs-6 full-width-mobile">
                            <strong>Followers</strong>
                            <followers :user={{ $user->id }}>
                            </followers>
                        </div>
                        <div class="col-md-6 mt-20 col-xs-6 full-width-mobile">
                            <strong>Following</strong>
                            <following :user={{ $user->id }}>
                            </following>
                        </div>
                    </div>
                    <div class="row mt-20">
                        <div class="col-md-12">
                            <strong>{{ $user->name }}'s favorite shows</strong>
                            <user-favorites :user={{ $user->id }}></user-favorites>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="panel-heading">
                <i class="fa fa-hand-paper-o"></i> This page is only available for users of the <strong>mundoDS</strong>!
            </div>
            @endif
         </div>
    </div>
</div>
@endsection