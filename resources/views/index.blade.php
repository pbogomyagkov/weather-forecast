@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <form method="POST" action="{{ route('forecast') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-5">
                                <input id="city" type="text" class="form-control" name="city" value="{{ old('city') ?? $city }}" placeholder="{{ __('City') }}" autofocus>

                                @if($errors->has('city'))
                                    <span class="text-danger" role="alert">
                                        {{ $errors->first('city') }}
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-5">
                                <input id="country" type="text" class="form-control" name="country" value="{{ old('country') ?? $country }}" placeholder="{{ __('Country') }}">

                                @if($errors->has('country'))
                                    <span class="text-danger" role="alert">
                                        {{ $errors->first('country') }}
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                        <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(isset($forecast))
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-10">
                            <p>{{ __('Average temperature for the next 10 days') }}</p>
                        </div>
                        <div class="col-md-2">
                            {{ $forecast }} {!! is_numeric($forecast) ? '&deg;C' : '' !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
