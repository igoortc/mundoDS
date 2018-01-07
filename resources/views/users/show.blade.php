@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h3>{{ $user->name }}</h3>
            </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $user->name }}
                    </div>

                    <div class="panel-body">
                        {{ $user->email }}
                        <follow
                            :following={{ $user->id }}
                            :follower={{ $user->follows() ? 'true' : 'false' }}
                        ></follow>
                    </div>
                </div>
         </div>
    </div>
</div>
@endsection