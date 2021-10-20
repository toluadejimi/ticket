@extends('layouts.app')
@section('title', 'Report')

@section('content')
    jjj
@stop
@section('script')
    <script>
        $(document).ready(function () {
            $('.navbar-default .navbar-nav li').removeClass('active');
            $('.navbar-default .navbar-nav li.about').addClass('active');
        });
    </script>
@stop