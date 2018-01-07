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
                        {{ $myProfile->email }}
                    </div>
         </div>
    </div>
</div>
@endsection