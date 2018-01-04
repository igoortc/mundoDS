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
                    <div class="panel-heading">
                        {{ $show->name }}
                    </div>

                    <div class="panel-body">
                        <img src={{ $show->poster }} class="poster">
                        {{ $show->synopsis }}
                    </div>
                    @if (Auth::check())
                        <div class="panel-footer">
                            <favorite
                                :show={{ $show->id }}
                                :favorited={{ $show->favorited() ? 'true' : 'false' }}
                            ></favorite>
                        </div>
                    @endif
                </div>
            @empty
                <p>No show created.</p>
            @endforelse

           {{ $shows->links() }}
        </div>
    </div>
</div>
@endsection
