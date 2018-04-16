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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            @if (Auth::user()->id != $user->id)
                            <a href="{{ url('user') }}/{{ $user->id }}">{{ $user->name }}</a>
                            <follow
                                :user_id={{ $user->id }}
                                :following_id={{ $user->followed() ? 'true' : 'false' }}
                                class="pull-right"
                            ></follow>
                            @endif
                            @if (Auth::user()->id == $user->id)
                                <a href="{{ url('my_profile') }}">{{ $user->name }}</a>
                            @endif
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-md-3 col-3 profile">
                                    <img src={{ $user->photo }}>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
                                    <p><i class="fa fa-birthday-cake"></i> {{ $user->age->diffForHumans(null, true) }}</p>
                                    <p><i class="fa fa-globe"></i> {{ $user->city }}</p>
                                    <p><i class="fa fa-quote-left"></i> {{ $user->bio }}</p>
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