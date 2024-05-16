@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Welcome') }}</div>

                <div class="card-body">
                    <form id="form-user" method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                        @csrf
                        @method("post")

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($name) ? $name : "" }}"  autocomplete="name"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ isset($email) ? $email : ""}}" required autocomplete="current-email">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <span for="canvas" class="col-md-4 col-form-label text-md-end">{{ __('Sign here') }}</span>
                            <div id="sign-canvas" class="col-md-6">
                                <canvas id="canvas" width="400" height="200" ></canvas>
                                <div id="canvas-clear">
                                    <button id="btn-clear" type="button">Clear</button>
                                </div>
                            </div>
                        </div>
                        <input data-code="{{isset($code) ? $code : ""}}" data-dni="{{ isset($dni) ? $dni : "" }}" name="data-user" id="data-user" hidden>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button id="btn-submit" type="submit" class="btn btn-info">
                                    {{ __('Submit') }}
                                </button>
                                <div id="message-form" class="mt-1"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


