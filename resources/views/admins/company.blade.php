@extends('layouts.app', ['pageSlug' => 'Eucomb', 'titlePage' => __('Gestión de la empresa')])

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
                                        <img src="{{ asset($company->imglogo) }}" alt="" height=" 150">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>{{ __('Subir logotipo') }}</label>
                                        <input type="file" name="logo" id="" accept="image/*">
                                        @if ($errors->has('logo'))
                                            <span id="text-logo" class="error text-danger" for="input-logo">
                                                {{ 'El ' . $errors->first('logo') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="name">{{ __('Nombre de la empresa') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                            id="input-nombre" aria-describedby="nombreHelp"
                                            placeholder="Nombre de la empresa" value="{{ old('nombre', $company->nombre) }}"
                                            aria-required="true" name="nombre">
                                        @if ($errors->has('nombre'))
                                            <span id="nombre-error" class="error text-danger" for="input-nombre">
                                                {{ $errors->first('nombre') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('direccion') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="direccion">{{ __('Dirección de la empresa') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}"
                                            name="direccion" id="input-direccion"
                                            value="{{ old('direccion', $company->direccion) }}" aria-required="true"
                                            aria-describedby="direccionHelp" placeholder="Dirección de la empresa"
                                            aria-required="true">
                                        @if ($errors->has('direccion'))
                                            <span id="direccion-error" class="error text-danger" for="input-direccion">
                                                {{ $errors->first('direccion') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="form-group{{ $errors->has('telefono') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="telefono">{{ __('Telefono') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}"
                                            name="telefono" id="input-telefono"
                                            value="{{ old('telefono', $company->telefono) }}" aria-required="true"
                                            aria-describedby="telefonoHelp" placeholder="Telefono de la empresa"
                                            aria-required="true">
                                        @if ($errors->has('telefono'))
                                            <span id="telefono-error" class="error text-danger"
                                                for="input-telefono">{{ $errors->first('telefono') }}</span>
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
                                            data-style="btn-primary" data-live-search="true" data-width="100%">
                                            <option value="">{{ __('Elija una opción') }}</option>
                                            @if ($company->double_points == 1)
                                                <option value="1" selected>Puntos normales</option>
                                                <option value="2">Puntos dobles</option>
                                            @endif
                                            @if ($company->double_points == 2)
                                                <option value="1">Puntos normales</option>
                                                <option value="2" selected>Puntos dobles</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer ml-auto mr-auto mt-5">
                                    <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
