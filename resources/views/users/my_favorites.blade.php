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
                    <div class="panel-heading">
                        <a href="{{ url('/show/' . $myFavorite->id) }}"> {{ $myFavorite->name }} </a>
                    </div>

                    <div class="panel-body">
                        {{ $myFavorite->synopsis }}
                    </div>
                    @if (Auth::check())
                        <div class="panel-footer">
                            <favorite
                                :show={{ $myFavorite->id }}
                                :favorited={{ $myFavorite->favorited() ? 'true' : 'false' }}
                            ></favorite>
                        </div>
                    @endif
                </div>
            @empty
                <p>You have no favorite shows.</p>
            @endforelse
            {{ $myFavorites->links() }}
         </div>
    </div>
</div>
@endsection