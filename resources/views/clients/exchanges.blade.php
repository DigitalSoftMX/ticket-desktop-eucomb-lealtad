@extends('layouts.app', ['pageSlug' => 'Clientes', 'titlePage' => __('Gestión de clientes')])

@section('content')

    <ul class="nav nav-pills nav-pills-success nav-pills-icons row" role="tablist">
        <li class="nav-item col-sm-6">
            <a class="nav-link active" href="#dashboard-1" role="tab" data-toggle="tab">
                <i class="material-icons" style="font-size: 35px">keyboard_arrow_up</i>
                {{ __('Por entregar') }}
            </a>
        </li>
        <li class="nav-item col-sm-6">
            <a class="nav-link" href="#schedule-1" role="tab" data-toggle="tab">
                <i class="material-icons" style="font-size: 35px">keyboard_arrow_down</i>
                {{ __('Historial') }}
            </a>
        </li>
    </ul>

    <div class="card mt-4 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-2">
                    <label class="label-control">Fecha de inicio</label>
                    <input class="form-control datetimepicker" id="input-date-ini" name="input-date-ini" type="text"
                        value="" placeholder="Fecha">
                </div>
                <div class="form-group col-sm-2">
                    <label class="label-control">Fecha de fin</label>
                    <input class="form-control datetimepicker" id="input-date-end" name="input-date-end" type="text"
                        value="" placeholder="Fecha">
                </div>

                <input type="text" class="form-control d-none" id="input-client_id"
                    placeholder="Escribe la membresía del usuario" name="client_id" value="{{ $client->id }}">

                <div class="form-group mt-3 col-sm-2">
                    <button id="exchanges" type="submit" class="btn btn-primary">{{ __('Buscar') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-content tab-space">
        <div class="tab-pane active" id="dashboard-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">
                                <a href="{{ route('clients.index') }}" title="Regresar a la lista" class="h4">
                                    <i class="tim-icons icon-minimal-left"></i>
                                </a>
                                {{ __('Buscar un usuario') }}
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="process">
                                    <thead class=" text-primary">
                                        <th>{{ __('Folio') }}</th>
                                        <th>{{ __('Estación') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Fecha y hora') }}</th>
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

        <div class="tab-pane" id="schedule-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="history">
                                    <thead class=" text-primary">
                                        <th>{{ __('Folio') }}</th>
                                        <th>{{ __('Estación') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Autorizado por') }}</th>
                                        <th>{{ __('Fecha y hora') }}</th>
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

@push('js')
    <script>
        $(document).ready(function() {
            init_calendar('input-date-ini', '01-01-2018', '07-07-2025');
            init_calendar('input-date-end', '01-01-2018', '07-07-2025');
        });

    </script>
@endpush
