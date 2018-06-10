@extends('layouts.app')

@section('content')
<div class="page-wrap">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h3>Hello, {{ $myProfile->name }}! <i class="fa fa-hand-peace-o"></i></h3>
                <edit-profile :user_id={{ $myProfile->id }}></edit-profile>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-md-3 col-3 profile">
                            <img src={{ $myProfile->photo }}>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
                            <p><i class="fa fa-globe"></i> {{ $myProfile->city }}</p>
                            <p><i class="fa fa-quote-left"></i> {{ $myProfile->bio }}</p>
                            <div class="analytics">
                                @if ($myProfile->nrEpisodes($myProfile->id) == 0)
                                    <p><i class="fa fa-list-ol"></i> You haven't watched any episodes</p>
                                @elseif ($myProfile->nrEpisodes($myProfile->id) == 1)
                                    <p><i class="fa fa-list-ol"></i> Watched {{ $myProfile->nrEpisodes($myProfile->id) }} episode</p>
                                @else
                                    <p><i class="fa fa-list-ol"></i> Watched {{ $myProfile->nrEpisodes($myProfile->id) }} episodes</p>
                                @endif
                                
                                @if ($myProfile->nrRatings($myProfile->id) == 0)
                                    <p><i class="fa fa-star-o"></i> You haven't rated any episodes</p>
                                @elseif ($myProfile->nrRatings($myProfile->id) == 1)
                                    <p><i class="fa fa-star-o"></i> Rated {{ $myProfile->nrRatings($myProfile->id) }} episode</p>
                                @else
                                    <p><i class="fa fa-star-o"></i> Rated {{ $myProfile->nrRatings($myProfile->id) }} episodes</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-20 col-xs-6 full-width-mobile">
                            <strong>Followers</strong>
                            <followers :user={{ $myProfile->id }}>
                            </followers>
                        </div>
                        <div class="col-md-6 mt-20 col-xs-6 full-width-mobile">
                            <strong>Following</strong>
                            <following :user={{ $myProfile->id }}>
                            </following>
                        </div>
                    </div>
                    <div class="row mt-20">
                        <div class="col-md-12">
                            <strong>Your favorite shows</strong>
                            <user-favorites :user={{ $myProfile->id }}></user-favorites>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection