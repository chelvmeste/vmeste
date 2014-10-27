@extends('layouts.app.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="alert alert-danger">
                    {{ trans('global.not-found.message') }}
                </div>
            </div>
        </div>
    </div>

@stop