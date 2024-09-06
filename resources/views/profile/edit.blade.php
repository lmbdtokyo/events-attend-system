@extends('adminlte::page')

@section('title', 'プロフィール')

@section('content_header')
    <h1>{{ __('Profile') }}</h1>
@stop

@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">所属組織</h2>
                        <ul>
                            @foreach($organizations as $organization)
                                <li>{{ $organization->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">権限</h2>
                        <ul>
                            @foreach($auths as $auth)
                                <li>{{ $auth->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@stop
