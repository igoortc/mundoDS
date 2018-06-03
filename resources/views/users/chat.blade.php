@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <div class="page-wrap np">
            <h3>Choose a friend to chat!</h3>
            <chat-list
                :friends="{{ $friends }}"
                :user="{{ Auth::user()->id }}"></chat-list>
        </div>
    @else
    <div class="panel-heading">
        <i class="fa fa-hand-paper-o"></i> This page is only available for users of the <strong>mundoDS</strong>!
    </div>
    @endif
@endsection