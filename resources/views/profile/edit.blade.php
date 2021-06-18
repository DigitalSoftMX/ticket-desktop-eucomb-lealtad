@extends('layouts.app', ['titlePage' => __('Perfil'), 'pageSlug' => 'Perfil'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form method="post" action="{{ auth()->user()->roles()->first()->id != 7 ? route('profile.update') : '' }}"
                        autocomplete="off" class="">
                        @csrf
                        @method('put')
                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Editar perfil') }}</h4>
                                <div class="row justify-content-center">
                                    <h4 class="row justify-content-center">{{ __('Código:') }}&nbsp;<strong>{{ auth()->user()->username }}</strong></h4> 
                                </div>
                                <p class="card-category">{{ __('Información de usuario') }}</p>
                            </div>
                            <div class="card-body ">

                                <div class="row">
                                    <label class="col-sm-3 col-form-label">{{ __('Nombre') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                name="name" id="input-name" type="text" placeholder="{{ __('Nombre') }}"
                                                value="{{ old('name', auth()->user()->name) }}" required="true"
                                                aria-required="true" />
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-name">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-3 col-form-label">{{ __('Apellido paterno') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('first_surname') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('first_surname') ? ' is-invalid' : '' }}"
                                                name="first_surname" id="input-first_surname" type="text"
                                                placeholder="{{ __('Apellido paterno') }}"
                                                value="{{ old('first_surname', auth()->user()->first_surname) }}"
                                                required="true" aria-required="true" />
                                            @if ($errors->has('first_surname'))
                                                <span id="first_surname-error" class="error text-danger"
                                                    for="input-first_surname">{{ $errors->first('first_surname') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-3 col-form-label">{{ __('Apellido materno') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('second_surname') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('second_surname') ? ' is-invalid' : '' }}"
                                                name="second_surname" id="input-second_surname" type="text"
                                                placeholder="{{ __('Apellido materno') }}"
                                                value="{{ old('second_surname', auth()->user()->second_surname) }}"
                                                required="true" aria-required="true" />
                                            @if ($errors->has('second_surname'))
                                                <span id="second_surname-error" class="error text-danger"
                                                    for="input-second_surname">{{ $errors->first('second_surname') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                name="email" id="input-email" type="email"
                                                placeholder="{{ __('Email') }}"
                                                value="{{ old('email', auth()->user()->email) }}" required />
                                            @if ($errors->has('email'))
                                                <span id="email-error" class="error text-danger"
                                                    for="input-email">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (auth()->user()->roles()->first()->id!=7)
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-success">{{ __('Guardar') }}</button>
                                </div>    
                            @endif
                        </div>
                    </form>
                </div>

                @if (auth()->user()->roles()->first()->id!=7)
                    <div class="col-md-6">
                        <form method="post" action="{{ auth()->user()->roles()->first()->id != 7 ? route('profile.password') : '' }}">
                            @csrf
                            @method('put')
                            <div class="card ">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title">{{ __('Cambiar contraseña') }}</h4>
                                    <p class="card-category">{{ __('Contraseña') }}</p>
                                </div>
                                <div class="card-body ">
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"
                                            for="input-current-password">{{ __('Contraseña actual') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                                <input
                                                    class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}"
                                                    input type="password" name="old_password" id="input-current-password"
                                                    placeholder="{{ __(' Contraseña Actual') }}" value="" required />
                                                @if ($errors->has('old_password'))
                                                    <span id="name-error" class="error text-danger"
                                                        for="input-name">{{ $errors->first('old_password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"
                                            for="input-password">{{ __('Nueva Contraseña') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                                <input
                                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                    name="password" id="input-password" type="password"
                                                    placeholder="{{ __('Nueva Contraseña') }}" value="" required />
                                                @if ($errors->has('password'))
                                                    <span id="password-error" class="error text-danger"
                                                        for="input-password">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"
                                            for="input-password-confirmation">{{ __('Confirmar nueva contraseña') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <input class="form-control" name="password_confirmation"
                                                    id="input-password-confirmation" type="password"
                                                    placeholder="{{ __('Confirmar nueva contraseña') }}" value="" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-success">{{ __('Cambiar Contraseña') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
