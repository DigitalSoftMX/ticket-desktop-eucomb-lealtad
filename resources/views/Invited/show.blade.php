@extends('layouts.app', ['pageSlug' => $pageSlug, 'titlePage' => 'Ventas de clientes por invitación'])

@section('content')
    <div class="tab-content text-center">
        <div class="tab-pane active" id="updates">
            <div class="row justify-content-center mt-5">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('Usuarios referidos') }}</h6>
                            <h3 class="title mb-0">
                                @if (isset($invited))
                                    {{ number_format($invited->references()->count(), 0) }}
                                @else
                                    {{ $references }}
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('Total de litros vendidos') }}</h6>
                            <h3 class="title mb-0">
                                @if (isset($invited))
                                    {{ number_format($invited->salesqrs()->sum('liters'), 2) }}
                                @else
                                    {{ $liters }}
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('Total de tickets escaneados') }}</h6>
                            <h3 class="title mt-0 mb-0">
                                @if (isset($invited))
                                    {{ number_format($invited->salesqrs()->count(), 0) }}
                                @else
                                    {{ $tickets }}
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">
                        @isset($invited)
                            <a href="{{ route($route) }}" title="Regresar a la lista" class="h4">
                                <i class="tim-icons icon-minimal-left"></i>
                            </a>
                        @endisset
                        @if (isset($invited))
                            {{ __('Movimientos de clientes por invitación de:') }}
                            <strong>{{ "{$invited->name} {$invited->first_surname} {$invited->second_surname}" }}</strong>
                        @else
                            {{ 'Movimientos generales de clientes por invitación' }}
                        @endif
                    </h4>
                    <p class="card-category">
                        {{ __('Aquí puedes las ventas de los clientes referidos por invitación') }}
                    </p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="input-month">{{ __('Mes') }}</label>
                            <select id="input-month" name="month" class="selectpicker show-menu-arrow"
                                data-style="btn-success" data-width="100%">
                                @foreach ($months as $m)
                                    <option value="{{ $m['id'] }}" @if ($m['id'] == $month) selected @endif>{{ $m['month'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="input-station">{{ __('Estación') }}</label>
                            <select id="input-station" name="station" class="selectpicker show-menu-arrow"
                                data-style="btn-success" data-width="100%">
                                @foreach ($stations as $station)
                                    <option value="{{ $station->id }}">{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @isset($users)
                            <div class="col-md-3">
                                <label for="input-users">{{ __('Usuarios Eucomb') }}</label>
                                <select id="input-users" name="users" class="selectpicker show-menu-arrow"
                                    data-style="btn-success" data-width="100%">
                                    <option value="">{{ __('Elije una opción') }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->username }}">
                                            {{ "{$user->name} {$user->first_surname} {$user->second_surname}" }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endisset
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                cellspacing="0" width="100%" id="usuarios">
                                <thead class="text-primary text-center">
                                    <th>{{ __('Membresía') }}</th>
                                    <th>{{ __('Litros') }}</th>
                                    <th>{{ __('Puntos') }}</th>
                                    <th>{{ __('Producto') }}</th>
                                    <th>{{ __('Estación') }}</th>
                                    <th>{{ __('Invitado por') }}</th>
                                    <th>{{ __('Fecha y Hora') }}</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('app')
    <script>
        // Valores default y llamada a las ventas QR
        let invited = "{{ $invited->username ?? '' }}";
        let station = document.getElementById('input-station').value;
        let month = document.getElementById('input-month').value;
        getSales(station, month);
        $("#input-station").change(function() {
            getvalues();
        });
        $("#input-month").change(function() {
            getvalues();
        });
        $("#input-users").change(function() {
            getvalues();
        });
        // Valores de los input
        function getvalues() {
            station = document.getElementById('input-station').value;
            month = document.getElementById('input-month').value;
            getSales(station, month);
        }
        // Obteniendo las ventas
        async function getSales(station, month) {
            try {
                if ("{{ $invited->username ?? '' }}" == '') {
                    invited = document.getElementById('input-users').value;
                }
                console.log(`{{ url('') }}/getsales/${station}/${month}/${invited}`);
                const resp = await fetch(`{{ url('') }}/getsales/${station}/${month}/${invited}`);
                const data = await resp.json();
                console.log(data);
                destruir_table("usuarios");
                $('#usuarios').find('tbody').empty();
                data.salesqrs.forEach(qr => {
                    $("#usuarios").find('tbody').append(
                        /* html */
                        `<tr class="text-center">
                            <td>${qr.membership}</td>
                            <td>${qr.liters}</td>
                            <td>${qr.points}</td>
                            <td>${qr.product}</td>
                            <td>${qr.station}</td>
                            <td>${qr.role}</td>
                            <td>${qr.data}</td>
                        </tr>`
                    );
                });
                iniciar_date('usuarios');
            } catch (error) {
                console.log(error)
            }
        }
    </script>
@endpush
