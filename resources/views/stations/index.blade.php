@extends('layouts.app', ['pageSlug' => 'Estaciones', 'titlePage' => __('Estaciones')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Estaciones') }}</h4>
                            <p class="card-category"> {{ __('Aquí puedes administrar las estaciones.') }}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('stations.create') }}"
                                        class="btn btn-sm btn-primary">{{ __('Agregar Estación') }}</a>
                                </div>
                            </div>
                            <div class="tab-content tab-space">
                                <div class="tab-pane active" id="link1" aria-expanded="true">
                                    <div class="table-responsive">
                                        <table
                                            class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                            cellspacing="0" width="100%" id="usuarios">
                                            <thead class=" text-primary">
                                                <th>{{ __('Nombre') }}</th>
                                                <th>{{ __('Dirección') }}</th>
                                                <th>{{ __('Teléfono') }}</th>
                                                <th>{{ __('Correo') }}</th>
                                                <th>{{ __('Número de estacion') }}</th>
                                                <th>{{ __('Imagen') }}</th>
                                                <th class="text-right">{{ __('Acciones') }}</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($stations as $station)
                                                    <tr>
                                                        <td>{{ $station->abrev }} - {{ $station->name }}</td>
                                                        <td>{{ $station->address }}</td>
                                                        <td>{{ $station->phone }}</td>
                                                        <td>{{ $station->email }}</td>
                                                        <td>{{ $station->number_station }}</td>
                                                        <td><img src="{{ asset($station->image) }}" alt="" height="40"
                                                                onclick="imagen_m('{{ asset($station->image) }}');"
                                                                data-toggle="modal" data-target="#exampleModalLong"
                                                                title="click para ampliar.">
                                                        </td>
                                                        <td class="td-actions text-right">
                                                            <form action="{{ route('stations.destroy', $station) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <a rel="tooltip" class="btn btn-info btn-icon btn-link"
                                                                    href="{{ route('stations.show', $station) }}">
                                                                    <i class="tim-icons icon-zoom-split"></i>
                                                                </a>
                                                                <a rel="tooltip" class="btn btn-success btn-icon btn-link"
                                                                    href="{{ route('stations.edit', $station) }}"
                                                                    data-original-title="" title="">
                                                                    <i class="tim-icons icon-pencil"></i>
                                                                </a>
                                                                <button type="button"
                                                                    class="btn btn-icon btn-danger btn-link"
                                                                    data-original-title="" title=""
                                                                    onclick="confirm('{{ __('¿Estás seguro de que deseas eliminar esta estación?') }}') ? this.parentElement.submit() : ''">
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
                @include('partials._modal',[$station='Estación'])
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function imagen_m(img) {
            $("#img_mos").attr("src", img);
        }

    </script>
@endpush
