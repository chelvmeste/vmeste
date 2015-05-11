@extends('layouts.app.layout')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3>{{ trans('offer.help-offer.title') }}</h3>
            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br />
                    @endforeach
                </div>
            @endif
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
        </div>
    </div>
    <div class="row">
        @if(Blind::isEnabled())
            @include('app.offer.help-offer-edit-form-blind')
        @else
            @include('app.offer.help-offer-edit-form')
        @endif
    </div>

@stop
