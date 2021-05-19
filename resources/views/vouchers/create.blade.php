@extends('layouts.app', ['pageSlug' => 'Vales', 'titlePage' => __('Gestión de vales')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 mx-auto d-block mt-3">
                    <form method="post" action="{{ route('vouchers.store') }}" autocomplete="off" class="form-horizontal">
                        @csrf
                        @method('post')
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">
                                    <a href="{{ route('vouchers.index') }}" title="Regresar a la lista" class="h4">
                                        <i class="tim-icons icon-minimal-left"></i>
                                    </a>
                                    {{ __('Agregar vale') }}
                                </h4>
                                <p class="card-category"></p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="name">{{ __('Nombre del vale') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            id="input-name" aria-describedby="nameHelp"
                                            placeholder="Escribe el nombre del vale" value="{{ old('name') }}"
                                            aria-required="true" name="name">
                                        @if ($errors->has('name'))
                                            <span id="name-error" class="error text-danger" for="input-name">
                                                {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('points') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="points">{{ __('Número de puntos del vale') }}</label>
                                        <input type="number"
                                            class="form-control{{ $errors->has('points') ? ' is-invalid' : '' }}"
                                            id="input-points" aria-describedby="pointsHelp"
                                            placeholder="Escribe el número de puntos del vale" value="{{ old('points') }}"
                                            aria-required="true" name="points">
                                        @if ($errors->has('points'))
                                            <span id="points-error" class="error text-danger" for="input-points">
                                                {{ $errors->first('points') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="form-group{{ $errors->has('value') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="value">{{ __('Valor del vale') }}</label>
                                        <input type="number"
                                            class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}"
                                            id="input-value" aria-describedby="valueHelp"
                                            placeholder="Escribe el valor del vale" value="{{ old('value') }}"
                                            aria-required="true" name="value">
                                        @if ($errors->has('value'))
                                            <span id="value-error" class="error text-danger" for="input-value">
                                                {{ $errors->first('value') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('id_status') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="input-id_status">{{ __('Status del vale') }}</label>
                                        <select id="input-id_status" name="id_status"
                                            class="selectpicker show-menu-arrow{{ $errors->has('id_status') ? ' is-invalid' : '' }}"
                                            data-style="btn-primary" data-live-search="true" data-width="100%">
                                            <option value="">{{ __('Elija una opción') }}</option>
                                            @foreach ($status as $s)
                                                <option value="{{ $s->id }}">{{ $s->name_status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="form-group{{ $errors->has('id_station') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="input-id_station">{{ __('Estación') }}</label>
                                        <select id="input-id_station" name="id_station"
                                            class="selectpicker show-menu-arrow{{ $errors->has('id_station') ? ' is-invalid' : '' }}"
                                            data-style="btn-primary" data-live-search="true" data-width="100%">
                                            <option value="">{{ __('Elija una opción') }}</option>
                                            @foreach ($stations as $station)
                                                <option value="{{ $station->id }}">{{ $station->name }}</option>
                                            @endforeach
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
