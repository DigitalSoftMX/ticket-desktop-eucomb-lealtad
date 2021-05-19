@extends('layouts.app', ['pageSlug' => 'Canjes', 'titlePage' => __('Validación de canjes')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Canjes') }}</h4>
                            <p class="card-category"> {{ __('Aquí puedes administrar los canjes realizados.') }}</p>
                        </div>
                        <div class="card-body">
                            <div class="card-header card-header-primary">
                                <div class="nav-tabs-navigation">
                                    <div class="nav-tabs-wrapper">
                                        <ul class="nav nav-tabs" data-tabs="tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#link1"
                                                    data-toggle="tab">{{ __('Proceso') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#link2"
                                                    data-toggle="tab">{{ __('Entrega') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#link3" data-toggle="tab">{{ __('Cobrar') }}</a>
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
                                            @include('partials._exchanges',[$status=11,$route='exchange.deliver'])
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="link2" aria-expanded="false">
                                    <div class="table-responsive">
                                        <table
                                            class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                            cellspacing="0" width="100%" id="autorizados">
                                            @include('partials._exchanges',[$status=12,$route='exchange.collect'])
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="link3" aria-expanded="false">
                                    <div class="table-responsive">
                                        <table
                                            class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                            cellspacing="0" width="100%" id="denegados">
                                            @include('partials._exchanges',[$status=13,$route='exchange.history'])
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
