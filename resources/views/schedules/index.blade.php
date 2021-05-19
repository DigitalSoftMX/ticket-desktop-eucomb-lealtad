@extends('layouts.app', ['pageSlug' => 'Turnos', 'titlePage' => __('Gestión de turnos de la estación')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Turnos') }}</h4>
                            <h5><a href="{{ route('stations.show', $station) }}" title="Regresar a la estación"
                                    class="h4">
                                    <i class="tim-icons icon-minimal-left"></i>
                                </a>
                                {{ __('Aquí puedes administrar los turnos de la estación.') }}
                                <p class="card-category"></p>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('schedules.create', $station) }}"
                                        class="btn btn-sm btn-primary">{{ __('Agregar Turno') }}</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="usuarios">
                                    <thead class=" text-primary">
                                        <th>{{ __('Nombre del turno') }}</th>
                                        <th>{{ __('Empieza') }}</th>
                                        <th>{{ __('Termina') }}</th>
                                        <th>{{ __('Fecha de Alta') }}</th>
                                        <th class="text-right">{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($schedules as $schedule)
                                            <tr>
                                                <td>{{ $schedule->name }}</td>
                                                <td>{{ $schedule->start }} hrs</td>
                                                <td>{{ $schedule->end }} hrs</td>
                                                <td>{{ $schedule->created_at->format('d/m/Y') }}</td>
                                                <td class="td-actions text-right">
                                                    <a rel="tooltip" class="btn btn-success btn-link"
                                                        href="{{ route('schedules.edit', [$station, $schedule]) }}"
                                                        data-original-title="" title="">
                                                        <i class="tim-icons icon-pencil"></i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                    <form
                                                        action="{{ route('schedules.destroy', [$station, $schedule]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class="btn btn-danger btn-link"
                                                            data-original-title="" title=""
                                                            onclick="confirm('{{ __('¿Estás seguro de que deseas eliminar este turno?') }}') ? this.parentElement.submit() : ''">
                                                            <i class="tim-icons icon-trash-simple"></i>
                                                            <div class="ripple-container"></div>
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
            </div>
        </div>
    </div>
@endsection
