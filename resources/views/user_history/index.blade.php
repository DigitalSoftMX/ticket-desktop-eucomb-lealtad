@extends('layouts.app', ['pageSlug' => 'Movimientos', 'titlePage' => __('Movimientos')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @csrf
                                <div class="form-group col-md-3">
                                    <label for="input-station">{{ __('Estación') }}</label>
                                    <select id="input-station" name="station" class="selectpicker show-menu-arrow"
                                        data-style="btn-success" data-live-search="true" data-width="100%">
                                        <option value="" selected disabled>{{ __('Elija una estacion') }}</option>
                                        @foreach ($stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="input-dispatcher">{{ __('Despachador') }}</label>
                                    <select id="input-dispatcher" name="dispatcher" class="selectpicker show-menu-arrow"
                                        data-style="btn-success" data-live-search="true" data-width="100%">
                                        <option value="" selected disabled>{{ __('Elija un despachador') }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="label-control">{{ __('A partir de') }}</label>
                                            <input class="form-control datetimepicker" id="input-date-ini" name="start"
                                                type="text" value="" placeholder="Fecha de inicio">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="label-control">{{ __('Hasta') }}</label>
                                            <input class="form-control datetimepicker" id="input-date-end" name="end"
                                                type="text" value="" placeholder="Fecha de fin">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2 mt-3">
                                    <button id="ventas" type="button" onclick="getHistory()"
                                        class="btn btn-success">{{ __('Buscar') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Ventas') }}</h4>
                            <p class="card-category"> {{ __('Aquí puedes observar las Ventas') }}</p>
                        </div>
                        <div class="card-body">
                            <div class="tab-pane active" id="link1" aria-expanded="true">
                                <div class="table-responsive">
                                    <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                        cellspacing="0" width="100%" id="usuarios">
                                        <thead class=" text-primary">
                                            <th>{{ __('Despachador') }}</th>
                                            <th>{{ __('ID Venta EUCOMB') }}</th>
                                            <th>{{ __('Producto') }}</th>
                                            <th>{{ __('Litros') }}</th>
                                            <th>{{ __('Pago') }}</th>
                                            <th>{{ __('Programa') }}</th>
                                            <th>{{ __('Estación') }}</th>
                                            <th>{{ __('Cliente') }}</th>
                                            <th>{{ __('# Isla') }}</th>
                                            <th>{{ __('# Bomba') }}</th>
                                            <th>{{ __('Fecha') }}</th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
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
            init_calendar('input-date-ini');
            init_calendar('input-date-end');
        });
        let station = '';
        $("#input-station").change(function() {
            station = document.getElementById('input-station').value;
            if (station) {
                getDispatchers(station);
            }
        });

        // Obtener la lista de despachadores
        async function getDispatchers(station) {
            try {
                const resp = await fetch(`{{ url('getdispatchers/${station}') }}`);
                const data = await resp.json();
                console.log(data);
                $("#input-dispatcher").find('option').remove();
                $('#input-dispatcher').append(
                    "<option value='' selected>Elija un despachador</option>");
                data.dispatchers.forEach(dispatcher => {
                    $('#input-dispatcher').append( /* html */ `
                            <option value='${dispatcher.id}'>
                                ${dispatcher.user.name} ${dispatcher.user.first_surname} ${dispatcher.user.second_surname}
                            </option>
                        `);
                });
                $("#input-dispatcher").selectpicker("refresh");
            } catch (error) {
                console.log(error);
            }
        }

        async function getHistory() {
            let button = document.getElementById('ventas');
            station = document.getElementById('input-station').value;
            let dispatcher = document.getElementById('input-dispatcher').value;
            let start = document.getElementById('input-date-ini').value;
            let end = document.getElementById('input-date-end').value;
            button.disabled = true;
            try {
                const resp = await fetch(`{{ url('gethistory') }}`, {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'post',
                    credentials: "same-origin",
                    body: JSON.stringify({
                        station,
                        dispatcher,
                        start,
                        end,
                    })
                })
                const data = await resp.json();
                console.log(data.sales);
                destruir_table("usuarios");
                $('#usuarios').find('tbody').empty();
                data.sales.forEach(sale => {
                    $('#usuarios').find('tbody').append( /* html */ `
                            <tr>                           
                                <td>${sale.dispatcher}</td>
                                <td>${sale.sale}</td>
                                <td>${sale.gasoline}</td>
                                <td>${sale.liters}</td>
                                <td>${sale.payment}</td>
                                <td>${sale.schedule}</td>
                                <td>${sale.station}</td>
                                <td>${sale.client}</td>
                                <td>${sale.island}</td>
                                <td>${sale.bomb}</td>
                                <td>${sale.date}</td>
                            </tr>
                        `);
                });
                iniciar_date('usuarios');

            } catch (error) {
                console.log(error)
            }
            button.disabled = false;
        }
    </script>
@endpush
