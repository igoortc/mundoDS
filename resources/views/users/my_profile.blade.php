@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h3>Hello, {{ $myProfile->name }}! <i class="fa fa-hand-peace-o"></i></h3>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $myProfile->name }}
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-md-3 col-3 profile">
                            <img src={{ $myProfile->photo }}>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
                            <p>{{ $myProfile->age }}</p>
                            <p>{{ $myProfile->city }}</p>
                            <p>{{ $myProfile->bio }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Followers
                            <followers :user={{ $myProfile->id }}>
                            </followers>
                        </div>
                        <div class="col-md-6">Following
                            <following :user={{ $myProfile->id }}>
                            </following>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection