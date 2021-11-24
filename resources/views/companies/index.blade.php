@extends('layouts.app', ['pageSlug' => 'Empresas', 'titlePage' => __('Gestión de Empresas para flotillas')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Empresas') }}</h4>
                            <p class="card-category">
                                {{ __('Aquí puedes gestionar a las empresas para flotillas.') }}
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('companies.create') }}"
                                        class="btn btn-sm btn-success">{{ __('Agregar Empresa') }}</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="empresas">
                                    <thead class="text-primary">
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('Apellidos') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Teléfono') }}</th>
                                        <th>{{ __('Rol') }}</th>
                                        <th>{{ __('Estación') }}</th>
                                        <th>{{ __('Fecha de Alta') }}</th>
                                        <th class="text-right">{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
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
@push('app')
    <script>
        iniciar_date('empresas');
    </script>
@endpush
