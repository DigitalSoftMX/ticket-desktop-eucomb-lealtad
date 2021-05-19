@extends('layouts.app', ['pageSlug' => 'Islas y Bombas', 'titlePage' => __('Gestión de islas y bombas de la estación')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 mx-auto d-block mt-3">
                    <form method="post" action="{{ route('islands.store', $station) }}" autocomplete="off"
                        class="form-horizontal">
                        @csrf
                        @method('post')
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">
                                    <a href="{{ route('islands.index', $station) }}" title="Regresar a la lista" class="h4">
                                        <i class="tim-icons icon-minimal-left"></i>
                                    </a>
                                    {{ __('Agregar Isla y bomba') }}
                                </h4>
                                <p class="card-category"></p>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group{{ $errors->has('island') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="island">{{ __('Número de isla') }}</label>
                                        <input type="number"
                                            class="form-control{{ $errors->has('island') ? ' is-invalid' : '' }}"
                                            id="input-island" aria-describedby="nameHelp"
                                            placeholder="Escribe el numero de la isla" value="{{ old('island') }}"
                                            aria-required="true" name="island">
                                        @if ($errors->has('island'))
                                            <span id="island-error" class="error text-danger" for="input-island">
                                                {{ $errors->first('island') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('bomb') ? ' has-danger' : '' }} col-sm-6">
                                        <label for="bomb">{{ __('Número de bomba') }}</label>
                                        <input type="number"
                                            class="form-control{{ $errors->has('bomb') ? ' is-invalid' : '' }}" name="bomb"
                                            id="input-bomb" value="{{ old('bomb') }}" aria-required="true"
                                            aria-describedby="startHelp" placeholder="Escribe el número de bomba"
                                            aria-required="true">
                                        @if ($errors->has('bomb'))
                                            <span id="bomb-error" class="error text-danger" for="input-bomb">
                                                {{ $errors->first('bomb') }}
                                            </span>
                                        @endif
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
