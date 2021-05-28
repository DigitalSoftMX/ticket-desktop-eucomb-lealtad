@extends('layouts.app', ['pageSlug' => 'Referidos', 'titlePage' => __('Cliente referido')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8 mx-auto d-block mt-3">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">
                                <a href="{{ route('references.index') }}" title="Regresar a la lista" class="h4">
                                    <i class="tim-icons icon-minimal-left"></i>
                                </a>
                                {{ __('Clientes referenciando a:') }}
                                <strong>{{ $reference->name }} {{ $reference->first_surname }}
                                    {{ $reference->second_surname }}</strong>
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
                                        @foreach ($hosts as $host)
                                            <tr>
                                                <td>{{ $host->user->username }}</td>
                                                <td>{{ $host->user->name }} {{ $host->user->first_surname }}
                                                    {{ $host->user->second_surname }}</td>
                                                <td>{{ $host->user->email }}</td>
                                                <td class="td-actions text-right">
                                                    <form
                                                        action="{{ route('dropreference', [$reference, $host->user]) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="button" class="btn btn-danger btn-link"
                                                            data-original-title="" title=""
                                                            onclick="confirm('{{ __('¿Estás seguro de que deseas desactivar este cliente?') }}') ? this.parentElement.submit() : ''">
                                                            <span class="material-icons-outlined">
                                                                close
                                                            </span>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mx-auto d-block mt-3">
                    <form method="post" action="{{ route('lookingforclients', true) }}" autocomplete="off"
                        class="form-horizontal" id="botonFormEnvioForm">
                        @csrf
                        @method('post')
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">{{ __('Buscar Clientes') }}</h4>
                                <p class="card-category">
                                    {{ __('Aquí puedes buscar a los proximos clientes que prodrán referir.') }}</p>
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
                    <div class="col-md-12 mx-auto d-block mt-3">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">{{ __('Clientes para referencia') }}</h4>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                        cellspacing="0" width="100%" id="clients">
                                        <thead class=" text-primary">
                                            <th>{{ __('Membresía') }}</th>
                                            <th>{{ __('Nombre') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th class="text-right">{{ __('Acciones') }}</th>
                                        </thead>
                                        <tbody>
                                            @foreach (session('users') as $user)
                                                @if ($user->id != $reference->id && $user->client->main->count() == 0 && $user->client->active != 1)
                                                    <tr>
                                                        <td>{{ $user->username }}</td>
                                                        <td>{{ $user->name }} {{ $user->first_surname }}
                                                            {{ $user->second_surname }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td class="td-actions text-right">
                                                            <form
                                                                action="{{ route('addreference', [$reference, $user]) }}"
                                                                method="post">
                                                                @csrf
                                                                <button type="button" class="btn btn-success btn-link"
                                                                    data-original-title="" title=""
                                                                    onclick="confirm('{{ __('¿Estás seguro de que deseas activar este cliente para referencia?') }}') ? this.parentElement.submit() : ''">
                                                                    <span class="material-icons-outlined">
                                                                        done_outline
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
        iniciar_date('clients');

    </script>
@endpush
