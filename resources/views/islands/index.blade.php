@extends('layouts.app', ['pageSlug' => 'Islas y Bombas', 'titlePage' => __('Gestión de islas y bombas de la
estación')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Islas y bombas') }}</h4>
                            <h5 class="card-title ">
                                <a href="{{ route('stations.show', $station) }}" title="Regresar a la estación" class="h4">
                                    <i class="tim-icons icon-minimal-left"></i>
                                </a>
                                {{ __('Aquí puedes administrar las islas y bombas de la estación.') }}
                                <p class="card-category"></p>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('islands.create', $station) }}"
                                        class="btn btn-sm btn-primary">{{ __('Agregar Isla y bomba') }}</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="usuarios">
                                    <thead class=" text-primary">
                                        <th>{{ __('Nombre de la estación') }}</th>
                                        <th>{{ __('Número de isla') }}</th>
                                        <th>{{ __('Número de bomba') }}</th>
                                        <th>{{ __('Fecha de Alta') }}</th>
                                        <th class="text-right">{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($islands as $island)
                                            <tr>
                                                <td>{{ $island->station->name }}</td>
                                                <td>{{ __('Isla') }} {{ $island->island }}</td>
                                                <td>{{ __('Bomba') }} {{ $island->bomb }}</td>
                                                <td>{{ $island->created_at->format('d/m/Y') }}</td>
                                                <td class="td-actions text-right">
                                                    <a rel="tooltip" class="btn btn-success btn-link"
                                                        href="{{ route('islands.edit', [$station, $island]) }}"
                                                        data-original-title="" title="">
                                                        <i class="tim-icons icon-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('islands.destroy', [$station, $island]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class="btn btn-danger btn-link"
                                                            data-original-title="" title=""
                                                            onclick="confirm('{{ __('¿Estás seguro de que deseas eliminar la isla y bomba?') }}') ? this.parentElement.submit() : ''">
                                                            <i class="tim-icons icon-trash-simple"></i>
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
