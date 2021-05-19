@extends('layouts.app', ['class' => 'login-page', 'page' => __(''), 'contentClass' => 'login-page'])

@section('content')
    <!--div class="col-lg-5 col-md-7 ml-auto mr-auto">
        <form class="form" method="post" action="{{ route('password.email') }}">
            @csrf

            <div class="card card-login card-white">
                <div class="card-header">
                    <img src="{{ asset('white') }}/img/card-primary.png" alt="">
                    <h1 class="card-title">{{ __('Reset password') }}</h1>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-email-85"></i>
                            </div>
                        </div>
                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}">
                        @include('alerts.feedback', ['field' => 'email'])
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-lg btn-block mb-3">{{ __('Send Password Reset Link') }}</button>
                </div>
            </div>
        </form>
    </div-->
    <div class="row pt-0 pb-0 bg-success">
        <div class="col-sm-4 mt-0 pl-0 pr-0" >
            <form class="form " method="post" action="{{ route('password.email') }}">
                @csrf
                <div class="card bg-success p-0 m-0" style="height: 100vh !important">
                    <div class="mt-5 ml-5 mr-5">
                        <div class="mt-5">
                            <div class="mx-auto d-block col-sm-8 mt-5">
                                <!--img class="mx-auto d-block mt-5" src="{{ asset('white') }}/img/svg/logo.svg" alt="" style="width: 30% !important"-->
                                <h3  class="text-white">RESTABLECER CONTRASEÑA</h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-5">
                        <div class="col-sm-8 mx-auto d-block">

                            <div class="form-group">
                                <label for="email" class="text-white">{{ __('Correo electrónico') }}</label>
                                <div >
                                    <input id="email"type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} bg-white" placeholder="{{ __('Email') }}">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <div>
                                    <button type="submit"  class="btn btn-simple btn-white">
                                        {{ __('Enviar enlace de recuperación') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-8 mt-0 p-0 bg-white">
        <lottie-player src="https://assets7.lottiefiles.com/packages/lf20_mdbdc5l7.json"   background="transparent" class="mx-auto d-block"  speed="1"  style="width:90%;" loop  autoplay></lottie-player>
            <!--img class="mx-auto d-block p-0 m-0" src="{{ asset('white') }}/img/svg/segunda.svg" alt="" style="height: 100vh !important"-->
        </div>
    </div>
@endsection
