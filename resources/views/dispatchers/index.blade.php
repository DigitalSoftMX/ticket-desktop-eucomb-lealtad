@extends('layouts.app', ['pageSlug' => 'Despachadores', 'titlePage' => __('Gestión de despachadores')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Despachadores') }}</h4>
                            <h5 class="card-title ">
                                @if ($station->id != null)
                                    <a href="{{ route('stations.show', $station) }}" title="Regresar a la estación"
                                        class="h4">
                                        <i class="tim-icons icon-minimal-left"></i>
                                    </a>
                                @endif
                                {{ __('Aquí puedes administrar a los despachadores.') }}
                                <p class="card-category"></p>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    @if ($station->id != null)
                                        <a href="{{ route('dispatcher.create', $station) }}"
                                            class="btn btn-sm btn-primary">{{ __('Agregar Despachador') }}</a>
                                    @else
                                        <a href="{{ route('dispatchers.create') }}"
                                            class="btn btn-sm btn-primary">{{ __('Agregar Despachador') }}</a>
                                    @endif
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="usuarios">
                                    <thead class=" text-primary">
                                        <th>{{ __('Despachador') }}</th>
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('Apellidos') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Teléfono') }}</th>
                                        <th>{{ __('Rol') }}</th>
                                        <th>{{ __('Estación') }}</th>
                                        <th>{{ __('Turno') }}</th>
                                        <th>{{ __('Isla y bomba') }}</th>
                                        <th>{{ __('Fecha de Alta') }}</th>
                                        <th class="text-right">{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($dispatchers as $dispatcher)
                                            <tr>
                                                <td>{{ $dispatcher->user->username }}</td>
                                                <td>{{ $dispatcher->user->name }}</td>
                                                <td>{{ $dispatcher->user->first_surname }}
                                                    {{ $dispatcher->user->second_surname }}</td>
                                                <td>{{ $dispatcher->user->email }}</td>
                                                <td>{{ $dispatcher->user->phone }}</td>
                                                <td>
                                                    @foreach ($dispatcher->user->roles as $role)
                                                        {{ $rol = $role->name }},
                                                    @endforeach
                                                </td>
                                                <td>{{ $dispatcher->station->name }}</td>
                                                <td>
                                                    @if ($dispatcher->schedule != null)
                                                        De: {{ $dispatcher->schedule->start }} hrs A:
                                                        {{ $dispatcher->schedule->end }} hrs
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($dispatcher->island != null)
                                                        Isla {{ $dispatcher->island->island }} - Bomba
                                                        {{ $dispatcher->island->bomb }}
                                                    @endif
                                                </td>
                                                <td>{{ $dispatcher->user->created_at->format('d/m/Y') }}</td>
                                                <td class="td-actions text-right">
                                                    <a rel="tooltip" class="btn btn-info btn-icon btn-link"
                                                        href="{{ route('invited.show', $dispatcher->user) }}">
                                                        <i class="tim-icons icon-zoom-split"></i>
                                                    </a>
                                                    @if ($station->id != null)
                                                        <a rel="tooltip" class="btn btn-success btn-link"
                                                            href="{{ route('dispatcher.edit', [$station, $dispatcher]) }}"
                                                            data-original-title="" title="">
                                                            <i class="tim-icons icon-pencil"></i>
                                                        </a>
                                                    @else
                                                        <a rel="tooltip" class="btn btn-success btn-link"
                                                            href="{{ route('dispatchers.edit', $dispatcher) }}"
                                                            data-original-title="" title="">
                                                            <i class="tim-icons icon-pencil"></i>
                                                        </a>
                                                    @endif
                                                    @if ($rol != 'usuario')
                                                        <form action="{{ route('dispatchers.destroy', $dispatcher) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="button" class="btn btn-danger btn-link"
                                                                data-original-title="" title=""
                                                                onclick="confirm('{{ __('¿Estás seguro de que deseas eliminar este usuario?') }}') ? this.parentElement.submit() : ''">
                                                                <i class="tim-icons icon-trash-simple"></i>
                                                                <div class="ripple-container"></div>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
