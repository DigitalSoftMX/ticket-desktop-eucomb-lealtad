@extends('layouts.app', ['pageSlug' => 'Validación de abonos', 'titlePage' => __('Validación de abonos')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 mx-auto d-block mt-3">
                    <form method="post" @if (isset($station)) action="{{ route('balances.store', $station) }}"    
                    @else
                                    action="{{ route('balance.store') }}" @endif
                        enctype="multipart/form-data" autocomplete="off" class="form-horizontal">
                        @csrf
                        @method('post')
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">
                                    @if (isset($station))
                                        <a href="{{ route('balances.index', $station) }}" title="Regresar a la lista"
                                            class="h4"></a>
                                    @else
                                        <a href="{{ route('balance.index') }}" title="Regresar a la lista" class="h4"></a>
                                    @endif
                                    <i class="tim-icons icon-minimal-left"></i>
                                    {{ __('Registrar Abono') }}
                                </h4>
                                <p class="card-category"></p>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group{{ $errors->has('membership') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="membership">{{ __('Membresía') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('membership') ? ' is-invalid' : '' }}"
                                            id="input-membership" aria-describedby="membershipHelp"
                                            placeholder="Escribe la membresía" value="{{ old('membership') }}"
                                            aria-required="true" name="membership">
                                        @if ($errors->has('membership'))
                                            <span id="membership-error" class="error text-danger" for="input-membership">
                                                {{ $errors->first('membership') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('balance') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="balance">{{ __('Cantidad') }}</label>
                                        <input type="number" step="100" min="100"
                                            class="form-control{{ $errors->has('balance') ? ' is-invalid' : '' }}"
                                            id="input-balance" aria-describedby="balanceHelp"
                                            placeholder="Escribe la cantidad" value="{{ old('balance', 100) }}"
                                            aria-required="true" name="balance">
                                        @if ($errors->has('balance'))
                                            <span id="balance-error" class="error text-danger" for="input-balance">
                                                {{ $errors->first('balance') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div
                                        class="form-group{{ $errors->has('station_id') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="input-station_id">Estación</label>
                                        <select id="input-station_id" name="station_id" title="Seleccionar"
                                            class="mt-1 selectpicker show-menu-arrow{{ $errors->has('station_id') ? ' is-invalid' : '' }}"
                                            data-style="btn-success" data-live-search="true" data-width="100%">
                                            @if (isset($station))
                                                <option value="{{ $station->id }}" selected>{{ $station->name }}
                                                </option>
                                            @else
                                                @foreach ($stations as $station)
                                                    <option value="{{ $station->id }}">{{ $station->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="image">{{ __('Imagen') }}</label><br>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn btn-outline-secondary btn-file">
                                                <span class="fileinput-new">Seleccionar Imagen</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="image" accept="image/png, image/jpeg">
                                                @if ($errors->has('image'))
                                                    <span class="error text-danger" for="input-image" id="image-error">
                                                        {{ $errors->first('image') }}
                                                    </span>
                                                @endif
                                                </input>
                                            </span>
                                            <span class="fileinput-filename"></span>
                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput"
                                                style="float: none">&times;</a>
                                        </div>

                                    </div>
                                </div>

                                <div class="card-footer ml-auto mr-auto mt-5">
                                    <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
