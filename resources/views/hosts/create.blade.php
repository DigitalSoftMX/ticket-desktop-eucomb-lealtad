@extends('layouts.app', ['pageSlug' => 'Referidos', 'titlePage' => __('Usuario a referir')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-9 mx-auto d-block mt-3">
                    <form method="post" action="{{ route('lookingforclients', true) }}" autocomplete="off"
                        class="form-horizontal" id="botonFormEnvioForm">
                        @csrf
                        @method('post')
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">
                                    <a href="{{ route('references.index') }}" title="Regresar a la lista" class="h4">
                                        <i class="tim-icons icon-minimal-left"></i>
                                    </a>
                                    {{ __('Buscar Clientes') }}
                                </h4>
                                <p class="card-category">
                                    {{ __('Aquí puedes buscar a los proximos clientes a referir.') }}</p>
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
                                    <button type="submit" class="btn btn-success"
                                        id="botonFormEnvio">{{ __('Buscar') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (session('users'))
                <div class="row-justify-content-center">
                    <div class="col-md-9 mx-auto d-block mt-3">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">
                                    <a href="{{ route('references.index') }}" title="Regresar a la lista" class="h4">
                                        <i class="tim-icons icon-minimal-left"></i>
                                    </a>
                                    {{ __('Clientes') }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                        cellspacing="0" width="100%" id="usuarios">
                                        <thead class=" text-primary">
                                            <th>{{ __('Membresía') }}</th>
                                            <th>{{ __('Nombre') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th class="text-right">{{ __('Acciones') }}</th>
                                        </thead>
                                        <tbody>
                                            @foreach (session('users') as $user)
                                                @if ($user->client->main->count() == 0)
                                                    <tr>
                                                        <td>{{ $user->username }}</td>
                                                        <td>{{ $user->name }} {{ $user->first_surname }}
                                                            {{ $user->second_surname }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td class="td-actions text-right">
                                                            <form action="{{ route('references.update', $user) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('put')
                                                                <button type="button"
                                                                    class="btn btn-{{ $user->client->active == 0 ? 'success' : 'danger' }} btn-link"
                                                                    data-original-title="" title=""
                                                                    onclick="confirm('{{ __('¿Estás seguro de que deseas ' . ($user->client->active == 0 ? 'activar' : 'desactivar') . ' este cliente?') }}') ? this.parentElement.submit() : ''">
                                                                    <span class="material-icons-outlined">
                                                                        {{ $user->client->active == 0 ? 'done_outline' : 'close' }}
                                                                    </span>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('references')
    <script>
        $(document).ready(function() {
            @if (session('users') !== null)
                console.log('deslizar hacia abajo')
            @endif
        });

    </script>
@endpush
