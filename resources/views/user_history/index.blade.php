@extends('layouts.app', ['pageSlug' => 'Movimientos', 'titlePage' => __('Movimientos')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
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
                                        <tbody>
                                            @foreach ($sales as $sale)
                                                <tr>
                                                    @if ($sale->dispatcher != null)
                                                        <td>{{ $sale->dispatcher->user->username }}</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    <td>{{ $sale->sale }}</td>
                                                    <td>{{ $sale->gasoline->name }}</td>
                                                    <td>{{ $sale->liters }}</td>
                                                    <td>${{ $sale->payment }}</td>
                                                    @if ($sale->schedule != null)
                                                        <td>{{ $sale->schedule->name }}</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    <td>{{ $sale->station->name }}</td>
                                                    <td>{{ $sale->client->user->username }}</td>
                                                    <td>{{ $sale->no_island }}</td>
                                                    <td>{{ $sale->no_bomb }}</td>
                                                    <td>{{ $sale->created_at }}</td>
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
    </div>
@endsection
