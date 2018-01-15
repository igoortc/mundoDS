@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <h3>Hey, {{ Auth::user()->name }}! <i class="fa fa-user-secret" aria-hidden="true"></i> Here's your dashboard.</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createShow">Create new show!</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#manageShows">Manage shows</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#manageUsers">Manage users</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#manageContent">Manage reported conted</button>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <h4>Your favorite shows</h4>
            <dash-favorites :user={{ Auth::user()->id }}></dash-favorites>
        </div>
    </div>
    <div class="row friendships">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 followers">
            <h4>Your followers</h4>
            <followers :user={{ Auth::user()->id }}>
            </followers>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 following">
            <h4>People you follow</h4>
            <following :user={{ Auth::user()->id }}>
            </following>
        </div>
    </div>
</div>
<div class="modal fade" id="createShow" tabindex="-1" role="dialog" aria-labelledby="createShow" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <show-create></show-create>
  </div>
</div>
<div class="modal fade" id="createShow" tabindex="-1" role="dialog" aria-labelledby="manageShows" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <show-manage></show-manage>
  </div>
</div>
<div class="modal fade" id="createShow" tabindex="-1" role="dialog" aria-labelledby="manageUsers" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <user-manage></user-manage>
  </div>
</div>
<div class="modal fade" id="createShow" tabindex="-1" role="dialog" aria-labelledby="manageContent" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <content-manage></content-manage>
  </div>
</div>
@endsection