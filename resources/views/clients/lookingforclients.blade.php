@extends('layouts.app', ['pageSlug' => 'Clientes', 'titlePage' => __('Gestión de clientes')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 mx-auto d-block mt-3">
                    <form method="post" action="{{ route('lookingforclients') }}" autocomplete="off"
                        class="form-horizontal" id="botonFormEnvioForm">
                        @csrf
                        @method('post')
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">{{ __('Clientes') }}</h4>
                                <p class="card-category"> {{ __('Aquí puedes administrar a los clientes.') }}</p>
                            </div>

                            <div class="card-body">
                                <h4>{{ __('Búsqueda por filtro') }}</h4>
                                @if ($errors->has('empty'))
                                    <span class="text-danger">
                                        {{ __('Debe proporcionar al menos un dato del usuario para buscarlo') }}
                                    </span>
                                @endif
                                <div class="row mt-3 justify-content-center">
                                    <div class="col-sm-9">
                                        <label for="membership">{{ __('Membresía') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('membership') ? ' is-invalid' : '' }}"
                                            name="membership" id="input-membership" value="{{ old('membership') }}"
                                            aria-required="true" aria-describedby="membershipHelp"
                                            placeholder="Escribe la membresía del usuario" aria-required="true">
                                        @if ($errors->has('membership'))
                                            <span id="membership-error" class="error text-danger" for="input-membership">
                                                {{ $errors->first('membership') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-3 justify-content-center">
                                    <div class="col-sm-9">
                                        <label for="name">{{ __('Nombre') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            id="input-name" aria-describedby="nameHelp"
                                            placeholder="Escribe el nombre del usuario" value="{{ old('name') }}"
                                            aria-required="true" name="name">
                                        @if ($errors->has('name'))
                                            <span id="name-error" class="error text-danger" for="input-name">
                                                {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mt3 justify-content-center">
                                    <div class="col-sm-9">
                                        <label for="lastname">{{ __('Apellidos') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
                                            name="lastname" id="input-lastname" value="{{ old('lastname') }}"
                                            aria-required="true" aria-describedby="lastnameHelp"
                                            placeholder="Escribe los apellidos del usuario" aria-required="true">
                                        @if ($errors->has('lastname'))
                                            <span id="lastname-error" class="error text-danger" for="input-lastname">
                                                {{ $errors->first('lastname') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mt-3 justify-content-center">
                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} col-sm-9">
                                        <label for="email">{{ __('Email') }}</label>
                                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="email" id="input-email" type="email" value="{{ old('email') }}"
                                            aria-required="true" aria-describedby="emailHelp"
                                            placeholder="Escribe el email del usuario" aria-required="true">
                                        @if ($errors->has('email'))
                                            <span id="email-error" class="error text-danger" for="input-email">
                                                {{ $errors->first('email') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-footer ml-auto mr-auto mt-5">
                                    <button type="submit" class="btn btn-success" id="botonFormEnvio">{{ __('Buscar') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
