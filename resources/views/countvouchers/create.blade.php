@extends('layouts.app', ['pageSlug' => 'Rango de vales', 'titlePage' => __('Gestión de vales')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 mx-auto d-block mt-3">
                    <form method="post" action="{{ route('countvouchers.store') }}" autocomplete="off" id="botonFormEnvioForm"
                        class="form-horizontal">
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
                                    <div class="form-group{{ $errors->has('min') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="min">{{ __('Número mínimo de los vales') }}</label>
                                        <input type="number"
                                            class="form-control{{ $errors->has('min') ? ' is-invalid' : '' }}"
                                            id="input-min" aria-describedby="minHelp" placeholder="Escribe el número mínimo"
                                            value="{{ old('min', $min) }}" aria-required="true" name="min">
                                        @if ($errors->has('min'))
                                            <span id="min-error" class="error text-danger" for="input-min">
                                                {{ $errors->first('min') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('max') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="max">{{ __('Número máximo de los vales') }}</label>
                                        <input type="number"
                                            class="form-control{{ $errors->has('max') ? ' is-invalid' : '' }}"
                                            id="input-max" aria-describedby="maxHelp" placeholder="Escribe el número máximo"
                                            value="{{ old('max') }}" aria-required="true" name="max">
                                        @if ($errors->has('max'))
                                            <span id="max-error" class="error text-danger" for="input-max">
                                                {{ $errors->first('max') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if (auth()->user()->roles[0]->id != 3)
                                    <div class="row mt-3">
                                        <div
                                            class="form-group{{ $errors->has('id_station') ? ' has-danger' : '' }} col-sm-6">
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
                                @endif
                                @if (auth()->user()->roles[0]->id == 3)
                                    <input type="number" name="id_station"
                                        value="{{ auth()->user()->admin->station->id }}" hidden>
                                @endif
                                <div class="card-footer ml-auto mr-auto mt-5">
                                    <button type="submit" class="btn btn-primary" id="botonFormEnvio">{{ __('Guardar') }}</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
