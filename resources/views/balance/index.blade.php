@extends('layouts.app', ['pageSlug' => 'Validación de abonos', 'titlePage' => __('Validación de abonos')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Abonos') }}</h4>
                            <h5 class="card-title ">
                                @isset($station)
                                    <a href="{{ route('stations.show', $station) }}" title="Regresar a la estación"
                                        class="h4">
                                        <i class="tim-icons icon-minimal-left"></i>
                                    </a>
                                @endisset
                                {{ __('Aquí puedes administrar los abonos realizados.') }}
                                <p class="card-category"></p>
                            </h5>
                        </div>
                        <div class="card-body">
                            @if (auth()->user()->roles()->first()->id != 7)
                                <div class="row">
                                    <div class="col-12 text-right">
                                        @if (isset($station))
                                            <a href="{{ route('balances.create', $station) }}"
                                                class="btn btn-sm btn-primary">{{ __('Realizar Abono') }}</a>
                                        @else
                                            <a href="{{ route('balance.create') }}"
                                                class="btn btn-sm btn-primary">{{ __('Realizar Abono') }}</a>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="card-header card-header-primary">
                                <div class="nav-tabs-navigation">
                                    <div class="nav-tabs-wrapper">
                                        <ul class="nav nav-tabs" data-tabs="tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#link1"
                                                    data-toggle="tab">{{ __('Pendientes') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#link2"
                                                    data-toggle="tab">{{ __('Autorizados') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#link3"
                                                    data-toggle="tab">{{ __('Denegados') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content tab-space">
                                <div class="tab-pane active" id="link1" aria-expanded="true">
                                    <div class="table-responsive">
                                        <table
                                            class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                            cellspacing="0" width="100%" id="usuarios">
                                            @include('partials._balances',[$status=1])
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="link2" aria-expanded="false">
                                    <div class="table-responsive">
                                        <table
                                            class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                            cellspacing="0" width="100%" id="autorizados">
                                            @include('partials._balances',[$status=2])
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="link3" aria-expanded="false">
                                    <div class="table-responsive">
                                        <table
                                            class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                            cellspacing="0" width="100%" id="denegados">
                                            @include('partials._balances',[$status=3])
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('partials._modal')
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function imagen_mostrar(img) {
            $("#img_mos").attr("src", img);
        }

    </script>
@endpush
