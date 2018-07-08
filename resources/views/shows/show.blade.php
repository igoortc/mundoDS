@extends('layouts.app')

@section('content')
<div class="page-wrap">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3 poster">
                        <img src={{ $show->poster }}>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9 showInfo">
                        <p>{{ $show->name }}</p>
                        @if (Auth::check())
                            <favorite
                                :show={{ $show->id }}
                                :favorited={{ $show->favorited() ? 'true' : 'false' }}
                            ></favorite>
                        @endif
                        @if (Auth::user()->admin)
                            <show-manage :show_id={{ $show->id }}></show-manage>
                        @endif
                        <div class="showDetail">
                            <span>{{ $show->getAverage($show->id) }} <i class="fa fa-star"></i> | {{ $show->seasons }} seasons | </span>
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
                        <div class="synopsis"><i class="fa fa-quote-left"></i> {{ $show->synopsis }}</div>
                        @if (Auth::check())
                            <episodes 
                                :show={{ $show->id }}
                                :user={{ Auth::user()->id }}
                            ></episodes>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6 full-width-mobile col-xl-offset-3 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">
                        <suggestions :show_id={{ $show->id }} />
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6 full-width-mobile col-xl-offset-1 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                        <fans :show_id={{ $show->id }} />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('scripts.firebase')