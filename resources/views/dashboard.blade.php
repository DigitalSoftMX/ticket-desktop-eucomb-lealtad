@extends('layouts.app', ['pageSlug' => 'dashboard', 'titlePage' => __('dashboard')])

@section('content')

    <div class="tab-content text-center">
        <!--div class="tab-pane active" id="home">
            
        </div-->

        <div class="tab-pane active" id="updates">
            <div class="row">
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">Usuarios registrados</h6>
                            <h3 class="title mb-0">{{number_format($clientes_totales,0)}}</h3>
                                @if($clientes_mes_actual > 0)
                                    <a class="text-success mt-0 mb-0">
                                        +{{$clientes_mes_actual}}
                                    </a>
                                @elseif($clientes_mes_actual == 0)
                                    <a class="text-muted mt-0 mb-0">
                                        {{$clientes_mes_actual}}
                                    </a>
                                @else
                                    <a class="text-danger mt-0 mb-0">
                                        {{$clientes_mes_actual}}
                                    </a>
                                @endif
                        </div>
                    </div>
                </div>
            
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">Total de vales entregados</h6>
                            <h3 class="title mb-0">{{number_format($dashboar['exchange'], 0)}}</h3>
                            <a  class=" mt-1 mb-1">
                                <br>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">litros vendidos</h6>
                            <h3 class="title mb-0">{{number_format($dashboar['liters'], 2)}}</h3>
                            <a  class=" mt-1 mb-1">
                                <br>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">total de tickets escaneados</h6>
                            <h3 class="title mt-0 mb-0">{{number_format($dashboar['tickets'], 0)}}</h3>
                            <a  class=" mt-1 mb-1">
                                <br>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8">
                    <x-MainGraphicsDashboard number="4" :stations="$stations"/>
                </div>  
                <div class="col-lg-4">
                    <x-DetailsStationDashboard title="DETALLES POR ESTACIÓN" :stations="$stations"/>
                </div>
            </div>

            @php
                $m = 0;
            @endphp

            <div id="carouselExampleInterval" class="carousel slide m-4" data-ride="carousel">

                <div class="carousel-inner">
                    @for($i=1; $i<5; $i++)
                    <div class="carousel-item @if($i == 1) active @endif" data-interval="10000">
                        <div class="d-block w-100">
                            <div class="row">
                               @for($j=1; $j<4; $j++)
                               
                                <div class="col-lg-4">
                                    <div class="card card-chart">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <a class="text-muted">Litros vendidos por estación MENSUAL</a>
                                                </div>
                                                <div class="col-12 text-left">
                                                    <a class="text-success font-weight-bold h4">{{$array_meses_largos[$m]}}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-area pl-2 pr-3">
                                                <canvas id="chartLineGreen{{$m}}"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $m++;
                                @endphp
                                @endfor
                            </div>     
                        </div>
                    </div>
                    
                    
                    @endfor
                </div>
                <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
                    <i class="tim-icons icon-minimal-left text-white"></i>
                </a>
                <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
                    <i class="tim-icons icon-minimal-right text-white"></i>
                </a>
            </div>

            <x-ComparativeGraphDashboard :mounts="$array_meses_largos" :stations="$stations" :chart="$dashboar" />


            <div class="row">
                <div class="col-lg-6">
                    <div class="card overflowCards card-chart">
                        <div class="card-header text-left">
                            <div class="row">
                                <div class="col-sm-7">
                                    <h4 class="titlee text-muted font-weight-bold p-0 m-0 pl-4 pt-2" id="valesTotalH4">
                                    </h4>
                                </div>
                                <div class="col-sm-5 text-right">
                                    <select id="select_dash_2" class="selectpicker show-menu-arrow pr-4" data-style="btn-simple btn-github" data-width="50%">
                                        @for($md=0; $md<12; $md++)
                                            <option value="{{$md}}">{{$array_meses_largos[$md]}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">   
                                <div class="chart-area mt-5 pl-5 pr-2 mr-5">
                                    <canvas id="CountryChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card overflowCards card-chart">
                        <div class="card-header text-left">
                            <div class="row">
                                <div class="col-sm-7">
                                    <h4 class="titlee text-muted font-weight-bold p-0 m-0 pl-4 pt-2" id="ticketsTotalH4"></h4>
                                </div>
                                <div class="col-sm-5 text-right">
                                    <select id="select_dash_3" class="selectpicker show-menu-arrow pr-4" data-style="btn-simple btn-github" data-width="50%">
                                        @for($md=0; $md<12; $md++)
                                            <option value="{{$md}}">{{$array_meses_largos[$md]}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">   
                                <div class="chart-area mt-5 pl-5 pr-2 mr-5">
                                    <canvas id="CountryChart2"></canvas>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>

        </div>

        <div class="tab-pane" id="history">
            <div class="row">
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">Usuarios registrados</h6>
                            <h3 class="title mb-0">{{$clientes_totales}}</h3>
                                @if($clientes_mes_actual > 0)
                                    <a class="text-success mt-0 mb-0">
                                        +{{$clientes_mes_actual}}
                                    </a>
                                @elseif($clientes_mes_actual == 0)
                                    <a class="text-muted mt-0 mb-0">
                                        {{$clientes_mes_actual}}
                                    </a>
                                @else
                                    <a class="text-danger mt-0 mb-0">
                                        {{$clientes_mes_actual}}
                                    </a>
                                @endif
                        </div>
                    </div>
                </div>
            
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">Ventas totales</h6>
                            <h3 class="title mb-0">{{$ventas_totales}}</h3>
                            @if($crecimiento > 0)
                                <a class="text-success mt-0 mb-0">
                                    +{{$crecimiento}}%
                                </a>
                            @elseif($crecimiento == 0)
                                <a class="text-muted mt-0 mb-0">
                                    {{$crecimiento}}%
                                </a>
                            @else
                                <a class="text-danger mt-0 mb-0">
                                    {{$crecimiento}}%
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">Litros vendidos</h6>
                            <h3 class="title mb-0">{{$suma_tem_final}}</h3>
                            <a class="text-success mt-0 mb-0">
                                @if($crecimiento_litros > 0)
                                    <a class="text-success mt-0 mb-0">
                                        +{{$crecimiento_litros}}%
                                    </a>
                                @elseif( $crecimiento_litros == 0)
                                    <a class="text-muted mt-0 mb-0">
                                        {{$crecimiento_litros}}%
                                    </a>
                                @else
                                    <a class="text-danger mt-0 mb-0">
                                        {{$crecimiento_litros}}%
                                    </a>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">Abonos pendientes</h6>
                            <h3 class="title mt-0 mb-0">{{$abonos_totales}}</h3>
                            <a href="{{ route('balance.index') }}" class="badge badge-success mt-0 mb-0">
                                Autorizar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-interval="10000">
                        <div class="d-block w-100">
                            <div class="row">
                                @foreach($stations as $key => $estacion)
                                @if($key <= 2)
                                <div class="col-lg-4">
                                    <div class="card card-chart">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-1">
                                                    <i class="material-icons card-title md-24 text-light">local_gas_station</i>
                                                </div>
                                                <div class="col-11">
                                                    <a class="title card-title h4">{{$estacion->name}}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-area">
                                                <canvas id="chartLinePurple{{$key}}"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mx-auto d-block">
                                            <a class="btn btn-success btn-sm" href="{{ route('stations.show', $estacion) }}">Ver más</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>     
                        </div>
                    </div>
                    <div class="carousel-item" data-interval="10000">
                        <div class="d-block w-100">
                            <div class="row">
                                @foreach($stations as $key => $estacion)
                                @if($key > 2 && $key <= 5)
                                <div class="col-lg-4">
                                    <div class="card card-chart">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-1">
                                                    <i class="material-icons card-title md-24 text-light">local_gas_station</i>
                                                </div>
                                                <div class="col-11">
                                                    <a class="title card-title h4">{{$estacion->name}}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-area">
                                                <canvas id="chartLinePurple{{$key}}"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mx-auto d-block">
                                            <a class="btn btn-success btn-sm" href="{{ route('stations.show', $estacion) }}">Ver más</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>     
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-block w-100">
                            <div class="row">
                                @foreach($stations as $key => $estacion)
                                @if($key > 5)
                                <div class="col-lg-4">
                                    <div class="card card-chart">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-1">
                                                    <i class="material-icons card-title md-24 text-light">local_gas_station</i>
                                                </div>
                                                <div class="col-11">
                                                    <a class="title card-title h4">{{$estacion->name}}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-area">
                                                <canvas id="chartLinePurple{{$key}}"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mx-auto d-block">
                                            <a class="btn btn-success btn-sm" href="{{ route('stations.show', $estacion) }}">Ver más</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>     
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
                    <i class="tim-icons icon-minimal-left text-white"></i>
                </a>
                <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
                    <i class="tim-icons icon-minimal-right text-white"></i>
                </a>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-chart">
                        <div class="card-header">
                            <h5 class="card-category">Ventas totales por estación</h5>
                            <h3 class="card-title">
                                {{$suma_tem_final}}L
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="chartLineGreen"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card card-chart">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-sm-4 text-left">
                                    <h5 class="card-category">Ventas totales</h5>
                                    <h2 class="card-title">Litros</h2>
                                </div>
                                <div class="col-sm-8">
                                    <div class="btn-group btn-group-toggle mx-auto d-block" data-toggle="buttons">
                                        <label class="btn btn-sm btn-success btn-simple active" id="0">
                                            <input type="radio" name="options" checked>
                                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Magna</span>
                                            <span class="d-block d-sm-none">
                                                MA
                                            </span>
                                        </label>
                                        <label class="btn btn-sm btn-danger btn-simple" id="1">
                                            <input type="radio" class="d-none d-sm-none" name="options">
                                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Premium</span>
                                            <span class="d-block d-sm-none">
                                                PR
                                            </span>
                                        </label>
                                        <label class="btn btn-sm btn-dark btn-simple" id="2">
                                            <input type="radio" class="d-none" name="options">
                                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Diésel</span>
                                            <span class="d-block d-sm-none">
                                                DI
                                            </span>
                                        </label>
                                        <label class="btn btn-sm btn-primary btn-simple" id="3">
                                            <input type="radio" class="d-none" name="options">
                                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Ventas totales</span>
                                            <span class="d-block d-sm-none">
                                                VT
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="chartBig1"></canvas>
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
    
        function initDashboardPageCharts() {
            var liters_mouths = @json($dashboar['liters_mouths']);
            
            var stations_mouths_tickets = @json($dashboar['stations_mouths_tickets']);
            var stations_mouths_exchage = @json($dashboar['stations_mouths_exchage']);
            var stations = @json($stations);

            
            
            @foreach($stations as $key => $estacion)
                var ctx = document.getElementById("chartLinePurple{{$key}}").getContext("2d");

                var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

                gradientStroke.addColorStop(1, 'rgba(0, 0, 0,.2)');
                gradientStroke.addColorStop(0.5, 'rgba(5, 5, 5,.0)');
                gradientStroke.addColorStop(0, 'rgba(10, 10, 10,0)'); 

                var data = {
                    labels: @json($array_meses),
                    datasets: [{
                        label: "Litros vendidos en el mes",
                        fill: true,
                        backgroundColor: gradientStroke,
                        borderColor: '#00c907',
                        borderWidth: 2,
                        borderDash: [],
                        borderDashOffset: 0.0,
                        pointBackgroundColor: '#007d04',
                        pointBorderColor: 'rgba(255,255,255,0)',
                        pointHoverBackgroundColor: '#d346b1',
                        pointBorderWidth: 20,
                        pointHoverRadius: 4,
                        pointHoverBorderWidth: 15,
                        pointRadius: 4,
                        data: @json($meses_ventas_estacion[$key]),
                    }]
                };

                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: data,
                    options: gradientChartOptionsConfigurationWithTooltipPurple
                });
            @endforeach


            // grafica de pastel
            var ctxGreen = document.getElementById("chartLineGreen").getContext("2d");

            /*var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

            gradientStroke.addColorStop(1, 'rgba(66,134,121,0.15)');
            gradientStroke.addColorStop(0.4, 'rgba(66,134,121,0.0)'); //green colors
            gradientStroke.addColorStop(0, 'rgba(66,134,121,0)'); //green colors*/

            var data = {
                labels:[
                    @foreach($stations as $station)
                        '{{ $station->name }}',
                    @endforeach
                ],
                datasets: [{             
                    backgroundColor: [
                        'rgb(7, 120, 1)',
                        'rgb(8, 138, 1)',
                        'rgb(9, 156, 2)',
                        'rgb(30, 161, 24)',
                        'rgb(27, 179, 20)',
                        'rgb(13, 199, 4)',
                        'rgb(12, 214, 2)',
                        'rgb(16, 245, 5)',
                    ],
                    borderColor: '#0b9e03',
                    borderWidth: 2,
                    borderDash: [],
                    borderDashOffset: 0.0,
                    pointBackgroundColor: '#0b9e03',
                    pointBorderColor: 'rgba(255,255,255,0)',
                    pointHoverBackgroundColor: '#0b9e03',
                    pointBorderWidth: 20,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 15,
                    pointRadius: 4,
                    data: @json($suma_li_tem),
                }],
            };

            

            var myChart = new Chart(ctxGreen, {
                type: 'doughnut',
                data: data,
                options: gradientChartOptionsConfigurationWithTooltipGreen
            });


            //graficas de pastel
            
            @for($p=0; $p<12; $p++)
                var ctxGreen = document.getElementById("chartLineGreen{{$p}}").getContext("2d");
                var data = {
                labels:[
                    @foreach($stations  as $key => $station)
                        '{{ $station->abrev }}:     {{ number_format($dashboar['liters_mouths'][$p][$key],2) }} L',
                    @endforeach
                ],
                datasets: [{             
                    backgroundColor: [
                        "#026830", "#137c29", "#20a64c","#4fae52", "#64b34f", "#93c99c","#cbe4d2", "#e4f9e8"
                    ],
                    borderColor: [
                        "#026830", "#137c29", "#20a64c","#4fae52", "#64b34f", "#93c99c","#cbe4d2", "#e4f9e8"
                    ],
                    borderWidth: 2,
                    borderDash: [],
                    borderDashOffset: 0.0,
                    pointBackgroundColor: '#0b9e03',
                    pointBorderColor: 'rgba(255,255,255,0)',
                    pointHoverBackgroundColor: '#0b9e03',
                    pointBorderWidth: 20,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 15,
                    pointRadius: 4,
                    data: @json($dashboar['liters_mouths'][$p]),
                }],
            };

            gradientChartOptionsConfigurationWithTooltipGreen.plugins = {
      
                doughnutlabel: {
                    labels: [{
                    text: '{{ number_format(array_sum($dashboar['liters_mouths'][$p]), 2)}}L',
                    font: {
                        size: 20,
                        weight: 'bold'
                    }
                    }, {
                    text: 'Litros vendidos'
                    }]
                }
            };

            var myChartp = new Chart(ctxGreen, {
                type: 'doughnut',
                data: data,
                options: gradientChartOptionsConfigurationWithTooltipGreen
            });
            @endfor
            



            var chart_labels = @json($array_meses);
            var chart_data = @json($litros_magna_meses);


            var ctx = document.getElementById("chartBig1").getContext('2d');

            var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

            gradientStroke.addColorStop(1, 'rgba(0, 0, 0,.2)');
            gradientStroke.addColorStop(0.5, 'rgba(5, 5, 5,.0)');
            gradientStroke.addColorStop(0, 'rgba(10, 10, 10,0)'); 
            //purple colors
            var config = {
                type: 'line',
                data: {
                    labels: chart_labels,
                    datasets: [{
                        label: "Total de litros al mes",
                        fill: true,
                        backgroundColor: gradientStroke,
                        borderColor: '#00c907',
                        borderWidth: 2,
                        borderDash: [],
                        borderDashOffset: 0.0,
                        pointBackgroundColor: '#007d04',
                        pointBorderColor: 'rgba(255,255,255,0)',
                        pointHoverBackgroundColor: '#d346b1',
                        pointBorderWidth: 20,
                        pointHoverRadius: 4,
                        pointHoverBorderWidth: 15,
                        pointRadius: 4,
                        data: chart_data,
                    }]
                },
                options: gradientChartOptionsConfigurationWithTooltipPurple
            };

            var myChartData = new Chart(ctx, config);

            $("#0").click(function() {
                var data = myChartData.config.data;
                data.datasets[0].data = chart_data;
                data.datasets[0].borderColor = '#00c907';
                data.datasets[0].pointBackgroundColor = '#007d04';
                data.labels = chart_labels;
                myChartData.update();
            });

            $("#1").click(function() {
                var chart_data = @json($litros_premium_meses);
                var data = myChartData.config.data;
                data.datasets[0].data = chart_data;
                data.datasets[0].borderColor = '#e0000c';
                data.datasets[0].pointBackgroundColor = '#fa0000';
                data.labels = chart_labels;
                myChartData.update();
            });

            $("#2").click(function() {
                var chart_data = @json($litros_diesel_meses);
                var data = myChartData.config.data;
                data.datasets[0].data = chart_data;
                data.datasets[0].borderColor = '#0a0a0a';
                data.datasets[0].pointBackgroundColor = '#5c5c5c';
                data.labels = chart_labels;
                myChartData.update();
            });

            $("#3").click(function() {
                var chart_data = @json($litros_total);
                var data = myChartData.config.data;
                data.datasets[0].data = chart_data;
                data.datasets[0].borderColor = '#3b3b3b';
                data.datasets[0].pointBackgroundColor = '#7d7d7d';
                data.labels = chart_labels;
                myChartData.update();
            });

            document.getElementById("valesTotalH4").innerHTML = "Total de vales entregados: {{ number_format(array_sum($dashboar['stations_mouths_exchage'][0]),0) }}";

            var colors = ["#f81d1d", "#f81d1d", "#fa3333","#fa4d4d", "#fa6868", "#fb8282","#fca0a0", "#febcbc"];
            var ctxL2 = document.getElementById("CountryChart").getContext("2d");

            var gradientStroke = ctxL2.createLinearGradient(0, 230, 0, 50);

            gradientStroke.addColorStop(1, 'rgba(248, 29, 29,1.0)');
            gradientStroke.addColorStop(0.4, 'rgba(248, 29, 29,0.4)');
            gradientStroke.addColorStop(0, 'rgba(248, 29, 29,0)'); 

            var configL2 ={
                type: 'bar',
                responsive: true,
                data: {
                    labels:[
                        @foreach($stations as $station)
                            '',
                        @endforeach
                    ],
                    datasets: [
                        @foreach($stations as $key => $station)
                        {
                            label: '{{$station->abrev}}: {{$dashboar['stations_mouths_exchage'][0][$key]}}    ',
                            fill: true,
                            backgroundColor: colors[{{$key}}],
                            hoverBackgroundColor: gradientStroke,
                            borderColor: '#ffffff',
                            borderWidth: 2,
                            borderDash: [],
                            borderDashOffset: 0.0,
                            data: [{{$dashboar['stations_mouths_exchage'][0][$key]}}],
                        },
                        @endforeach   
                    ]
                },
                options: gradientBarChartConfiguration
            }

            var myChartL2 = new Chart(ctxL2, configL2);

            $( "#select_dash_2" ).change(function() {
                php_variable_2 = document.getElementById("select_dash_2").value;
                const total2 = stations_mouths_exchage[php_variable_2].reduce((a, b) => a + b);
                document.getElementById("valesTotalH4").innerHTML = "Total de vales entregados: "+total2+"";
                myChartL2.destroy();
                myChartL2 = new Chart(ctxL2, {
                type: 'bar',
                responsive: true,
                data: {
                    labels:[
                        @foreach($stations as $station)
                            '',
                        @endforeach
                    ],
                    datasets: [
                        @foreach($stations as $key => $station)
                        {
                            label: '{{$station->abrev}}: '+stations_mouths_exchage[php_variable_2][{{$key}}]+'    ',
                            fill: true,
                            backgroundColor: colors[{{$key}}],
                            hoverBackgroundColor: colors[{{$key}}],
                            borderColor: '#ffffff',
                            borderWidth: 2,
                            borderDash: [],
                            borderDashOffset: 0.0,
                            data:[stations_mouths_exchage[php_variable_2][{{$key}}]],
                        },
                        @endforeach
                        
                    ]
                },
                options: gradientBarChartConfiguration
                });
            });




            /*------------- */
            document.getElementById("ticketsTotalH4").innerHTML = "Total de tickets escaneados: {{ number_format(array_sum($dashboar['stations_mouths_tickets'][0]),0) }}";
            var colors2 = ["#026830", "#137c29", "#20a64c","#4fae52", "#64b34f", "#93c99c","#cbe4d2", "#e4f9e8"];
            var ctx = document.getElementById("CountryChart2").getContext("2d");

            var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

            gradientStroke.addColorStop(1, 'rgba(29,140,248,0.2)');
            gradientStroke.addColorStop(0.4, 'rgba(29,140,248,0.0)');
            gradientStroke.addColorStop(0, 'rgba(29,140,248,0)'); 

            var configL3 = {
            type: 'bar',
            responsive: true,
            data: {
                labels:[
                    @foreach($stations as $station)
                        '',
                    @endforeach
                ],
                datasets: [
                    @foreach($stations as $key => $station)
                    {
                        label: '{{$station->abrev}}: {{$dashboar['stations_mouths_tickets'][0][$key]}}    ',
                        fill: true,
                        backgroundColor: colors2[{{$key}}],
                        hoverBackgroundColor: colors2[{{$key}}],
                        borderColor: '#ffffff',
                        borderWidth: 2,
                        borderDash: [],
                        borderDashOffset: 0.0,
                        data: [{{$dashboar['stations_mouths_tickets'][0][$key]}}],
                    },
                    @endforeach
                    
                ]
            },
            options: gradientBarChartConfiguration
            };

            var myChartL = new Chart(ctx, configL3);


            // nueva grafica

            
            $( "#select_dash_3" ).change(function() {
                php_variable_3 = document.getElementById("select_dash_3").value;
                const total3 = stations_mouths_tickets[php_variable_3].reduce((a, b) => a + b);
                document.getElementById("ticketsTotalH4").innerHTML = "Total de tickets escaneados: "+total3+"";
                myChartL.destroy();
                myChartL = new Chart(ctx, {
                type: 'bar',
                responsive: true,
                data: {
                    labels:[
                        @foreach($stations as $station)
                            '',
                        @endforeach
                    ],
                    datasets: [
                        @foreach($stations as $key => $station)
                        {
                            label: '{{$station->abrev}}: '+stations_mouths_tickets[php_variable_3][{{$key}}]+'    ',
                            fill: true,
                            backgroundColor: colors2[{{$key}}],
                            hoverBackgroundColor: colors2[{{$key}}],
                            borderColor: '#ffffff',
                            borderWidth: 2,
                            borderDash: [],
                            borderDashOffset: 0.0,
                            data:[stations_mouths_tickets[php_variable_3][{{$key}}]],
                        },
                        @endforeach
                        
                    ]
                },
                options: gradientBarChartConfiguration
                });
            });


            //var chart_labelsL = @json($array_meses);
            //var chart_dataL = @json($litros_magna_meses);
            
            @stack('dash')

        };
        $(document).ready(function() {
          initDashboardPageCharts();
          $('.carousel').carousel();
        });
    </script>
@endpush
