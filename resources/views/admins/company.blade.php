@extends('layouts.app', ['pageSlug' => 'Eucomb', 'titlePage' => __('Gestión de la empresa Empresa')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 mx-auto d-block mt-3">
                    <form method="post" action="{{ route('company.update', $company) }}" autocomplete="off"
                        class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">
                                    {{ __('Información de la empresa') }}
                                </h4>
                                <p class="card-category"></p>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <img src="{{ asset($company->image) }}" height="150">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <label>{{ __('Subir logotipo') }}</label>
                                            <div class="justify-content-center">
                                                <span class="btn btn-success btn-sm btn-file">
                                                    <span class="fileinput-new">
                                                        {{ $company->image ? __('Cambiar imagen') : __('Agregar imagen') }}
                                                    </span>
                                                    <span class="fileinput-exists">{{ __('Cambiar imagen') }}</span>
                                                    <input type="file" name="logo" accept="image/*">
                                                </span>
                                            </div>
                                            @if ($errors->has('logo'))
                                                <span id="text-logo" class="error text-danger" for="input-logo">
                                                    {{ 'El ' . $errors->first('logo') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="name">{{ __('Nombre de la empresa') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            id="input-name" aria-describedby="nameHelp" placeholder="Nombre de la empresa"
                                            value="{{ old('name', $company->name) }}" aria-required="true" name="name">
                                        @if ($errors->has('name'))
                                            <span id="name-error" class="error text-danger" for="input-name">
                                                {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="address">{{ __('Dirección de la empresa') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                            name="address" id="input-address"
                                            value="{{ old('address', $company->address) }}" aria-required="true"
                                            aria-describedby="addressHelp" placeholder="Dirección de la empresa"
                                            aria-required="true">
                                        @if ($errors->has('address'))
                                            <span id="address-error" class="error text-danger" for="input-address">
                                                {{ $errors->first('address') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="phone">{{ __('Teléfono') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                            name="phone" id="input-phone" value="{{ old('phone', $company->phone) }}"
                                            aria-required="true" aria-describedby="phoneHelp"
                                            placeholder="Teléfono de la empresa" aria-required="true">
                                        @if ($errors->has('phone'))
                                            <span id="phone-error" class="error text-danger"
                                                for="input-phone">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('points') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="points">{{ __('Puntos de bienvenida para clientes nuevos') }}</label>
                                        <input type="number" class="form-control" name="points" id="input-points"
                                            value="{{ old('points', $company->points) }}" aria-required="true"
                                            aria-describedby="addressHelp"
                                            placeholder="Escribe los puntos de bienvenida para los clientes"
                                            aria-required="true">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div
                                        class="form-group{{ $errors->has('double_points') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="input-double_points">Puntos dobles</label>
                                        <select id="input-double_points" name="double_points"
                                            class="selectpicker show-menu-arrow{{ $errors->has('double_points') ? ' is-invalid' : '' }}"
                                            data-style="btn-success" data-width="100%">
                                            <option disabled>{{ __('Elija una opción') }}</option>
                                            <option value="1" @if ($company->double_points) selected @endif>{{ __('Puntos normales') }}</option>
                                            <option value="2" @if ($company->double_points == 2) selected @endif>{{ __('Puntos dobles') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer text-center mt-5">
                                    <button type="submit" class="btn btn-success">{{ __('Guardar') }}</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
