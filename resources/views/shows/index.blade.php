@extends('layouts.app')

@section('content')
<div class="page-wrap">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h3>All Shows</h3>
            </div>
            @forelse ($shows as $show)
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
                <p>No show created.</p>
            @endforelse

           {{ $shows->links() }}
        </div>
    </div>
</div>
@endsection
