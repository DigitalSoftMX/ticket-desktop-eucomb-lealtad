@extends('layouts.app', ['titlePage' => __('Perfil'), 'pageSlug' => 'Perfil'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 mx-auto d-block mt-3">
                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Perfil del usuario') }} {{ auth()->user()->name }}</h4>
                            <p class="card-category">{{ __('Información de usuario') }}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-3 col-form-label">{{ __('Nombre') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" name="name" id="input-name" type="text"
                                            placeholder="{{ __('Nombre') }}" value="{{ auth()->user()->name }}"
                                            required="true" aria-required="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label">{{ __('Apellido paterno') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" name="first_surname" id="input-first_surname"
                                            type="text" placeholder="{{ __('Apellido paterno') }}"
                                            value="{{ auth()->user()->first_surname }}" required="true"
                                            aria-required="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label">{{ __('Apellido materno') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" name="second_surname" id="input-second_surname"
                                            type="text" placeholder="{{ __('Apellido materno') }}"
                                            value="{{ auth()->user()->second_surname }}" required="true"
                                            aria-required="true" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" name="email" id="input-email" type="email"
                                            placeholder="{{ __('Email') }}" value="{{ auth()->user()->email }}"
                                            required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
