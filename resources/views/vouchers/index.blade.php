@extends('layouts.app', ['pageSlug' => 'Vales', 'titlePage' => __('Gestion de vales')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Vales') }}</h4>
                            <p class="card-category"> {{ __('Aquí puedes administrar los vales.') }}</p>
                        </div>
                        <div class="card-body">
                            <div class="card-header card-header-primary">
                                <div class="nav-tabs-navigation">
                                    <div class="nav-tabs-wrapper">
                                        <ul class="nav nav-tabs" data-tabs="tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#link1"
                                                    data-toggle="tab">{{ __('Vales') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#link2"
                                                    data-toggle="tab">{{ __('Conteo de vales') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content tab-space">
                                <div class="tab-pane active" id="link1" aria-expanded="true">
                                    @if (auth()->user()->roles[0]->id != 3)
                                        <div class="row">
                                            <div class="col-12 text-right">
                                                <a href="{{ route('vouchers.create') }}"
                                                    class="btn btn-sm btn-primary">{{ __('Agregar Vale') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="table-responsive">
                                        <table
                                            class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                            cellspacing="0" width="100%" id="usuarios">
                                            <thead class=" text-primary">
                                                <th>{{ __('Estación') }}</th>
                                                <th>{{ __('Nombre') }}</th>
                                                <th>{{ __('Número de puntos') }}</th>
                                                <th>{{ __('Valor') }}</th>
                                                <th>{{ __('Disponibles') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                @if (auth()->user()->roles[0]->id != 3)
                                                    <th class="text-right">{{ __('Acciones') }}</th>
                                                @endif
                                            </thead>
                                            <tbody>
                                                @foreach ($vouchers as $voucher)
                                                    <tr>
                                                        <td>{{ $voucher->station->name }}</td>
                                                        <td>{{ $voucher->name }}</td>
                                                        <td>{{ $voucher->points }}</td>
                                                        <td>{{ $voucher->value }}</td>
                                                        <td>
                                                            @if ($voucher->station->ranges->where('status', 4)->sum('remaining') > 0 and $voucher->station->ranges->where('status', 4)->sum('remaining') <= 10)
                                                                <span class="error text-danger">
                                                                    {{ $voucher->station->ranges->where('status', 4)->sum('remaining') }}
                                                                </span>
                                                            @else
                                                                {{ $voucher->station->ranges->where('status', 4)->sum('remaining') }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $voucher->status->name_status }}</td>
                                                        @if (auth()->user()->roles[0]->id != 3)
                                                            <td class="td-actions text-right">
                                                                <form action="{{ route('vouchers.destroy', $voucher) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <a rel="tooltip"
                                                                        class="btn btn-success btn-icon btn-link"
                                                                        href="{{ route('vouchers.edit', $voucher) }}"
                                                                        data-original-title="" title="">
                                                                        <i class="tim-icons icon-pencil"></i>
                                                                    </a>
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-danger btn-link"
                                                                        data-original-title="" title=""
                                                                        onclick="confirm('{{ __('¿Estás seguro de que deseas eliminar este vale?') }}') ? this.parentElement.submit() : ''">
                                                                        <i class="tim-icons icon-trash-simple"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="link2" aria-expanded="false">
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <a href="{{ route('countvouchers.create') }}"
                                                class="btn btn-sm btn-primary">{{ __('Agregar Vale') }}</a>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table
                                            class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                            cellspacing="0" width="100%" id="autorizados">
                                            <thead class=" text-primary">
                                                <th>{{ __('Estación') }}</th>
                                                <th>{{ __('Número mínimo') }}</th>
                                                <th>{{ __('Número máximo') }}</th>
                                                <th>{{ __('Disponibles') }}</th>
                                                <th>{{ __('Status') }}</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($countvouchers as $countvoucher)
                                                    <tr>
                                                        <td>{{ $countvoucher->station->name }}</td>
                                                        <td>{{ $countvoucher->min }}</td>
                                                        <td>{{ $countvoucher->max }}</td>
                                                        <td>
                                                            @if ($countvoucher->remaining > 0 and $countvoucher->remaining <= 10)
                                                                <span class="error text-danger">
                                                                    {{ $countvoucher->remaining }}
                                                                </span>
                                                            @else
                                                                {{ $countvoucher->remaining }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $countvoucher->estado ? $countvoucher->estado->name : '' }}
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
        </div>
    </div>
@endsection
