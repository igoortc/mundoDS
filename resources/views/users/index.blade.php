@extends('layouts.app')

@section('content')
<div class="page-wrap">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (Auth::check())
                <div class="page-header">
                    <h3>All Users</h3>
                </div>
                @forelse ($users as $user)
                    <div class="panel panel-default searchResults">
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
                    <p>There are no users.</p>
                @endforelse

                {{ $users->links() }}
            @else
            <div class="panel-heading">
                <i class="fa fa-hand-paper-o"></i> This page is only available for users of the <strong>mundoDS</strong>!
            </div>
            @endif
         </div>
    </div>
</div>
@endsection