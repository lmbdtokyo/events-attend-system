@extends('adminlte::page')

@section('title', 'ダッシュボード | イベント来場管理システム')

@section('content_header')
    <h1>{{ __('Dashboard') }}</h1>
@stop

@section('content')
    <p>{{ __("You're logged in!") }}</p>
@stop

@section('css')
    {{-- ページごとCSSの指定
    <link rel="stylesheet" href="/css/xxx.css">
    --}}
@stop

@section('js')
    <script> console.log('ページごとJSの記述'); </script>
@stop