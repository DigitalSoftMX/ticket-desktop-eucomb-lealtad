@extends('layouts.app', ['pageSlug' => $estacion_dashboard ?? 'Estaciones', 'titlePage' => __($station->name)])

@section('content')

    <div class="tab-content text-center">
        <!--div class="tab-pane active" id="home">
            
        </div-->
        <div class="tab-pane active" id="updates">
            <div class="row mr-0 ml-0">
                <div class="card mb-3 card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="statistics">
                                    <div class="card-body pt-0 pb-0 text-left">
                                        <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('Islas') }}</h6>
                                        <h3 class="title mt-0 mb-0">{{ $station->islands->count() }}</h3>
                                        <a href="{{ route('islands.index', $station) }}" class="badge badge-success mt-0 mb-0">
                                            {{ __('Agregar') }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="statistics">
                                    <div class="card-body pt-0 pb-0 text-left">
                                        <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('total de vales entregados') }}</h6>
                                        <h3 class="title mb-0">{{ number_format($station->exchanges->where('status',14)->count(), 0) }}</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="statistics">
                                    <div class="card-body pt-0 pb-0 text-left">
                                        <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('litros vendidos') }}</h6>
                                        <h3 class="title mb-0">{{ number_format($station_show['liters'],2) }}</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="">
                                    <div class="card-body pt-0 pb-0 text-left">
                                        <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('total de tickets escaneados') }}</h6>
                                        <h3 class="title mt-0 mb-0">
                                            {{ number_format($station_show['tickets'],0) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflowCards card-chart">
                        <div class="card-header">
                            <div class="row mt-1 mb-0">
                                <div class="col-sm-6 pt-2 text-left">
                                    <h3 class="card-subtitle text-muted">VENTAS TOTALES</h3>
                                </div>
                                <div class="col-sm-6">
                                    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                                        <label class="btn btn-sm btn-success btn-simple active" id="4">
                                            <input type="radio" name="options" checked>
                                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Magna</span>
                                            <span class="d-block d-sm-none">MA</span>
                                        </label>
                                        <label class="btn btn-sm btn-danger btn-simple" id="5">
                                            <input type="radio" class="d-none d-sm-none" name="options">
                                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Premium</span>
                                            <span class="d-block d-sm-none">PR</span>
                                        </label>
                                        <label class="btn btn-sm btn-primary btn-simple" id="7">
                                            <input type="radio" class="d-none" name="options">
                                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Ventas totales</span>
                                            <span class="d-block d-sm-none">
                                                VT
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-0 mb-0">
                                <div class="col-sm-5 text-left pt-3 pl-3">
                                    <h4 class="card-subtitle text-muted"> LITROS</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area_2 p-3">
                                <canvas id="chartBig1L"></canvas>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>

            @php
                $year = date('Y');
            @endphp

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflowCards card-chart">
                        <div class="card-header text-left">
                            <div class="row">
                                <div class="col-sm-7 pt-2">
                                    <h3 class="card-subtitle text-muted" id="valesTotalH3">Total de vales entregados:</h3>
                                </div>
                                <div class="col-sm-5 text-right">
                                    <select id="select_dash_1" class="selectpicker show-menu-arrow pr-4" data-style="btn-simple btn-github" data-width="50%">
                                        @for($mes_imprimir=0; $mes_imprimir<3; $mes_imprimir++)
                                            <option value="{{$mes_imprimir}}">{{$year - $mes_imprimir}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                
                                    <div class="chart-area_3 mt-1 pl-5 pr-2 mr-5">
                                        <canvas id="CountryChart"></canvas>
                                    </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflowCards card-chart">
                        <div class="card-header text-left">
                            <div class="row">
                                <div class="col-sm-7 pt-2">
                                    <h3 class="card-subtitle text-muted" id="ticketsTotalH3">Total de tickets escaneados:</h3>
                                </div>
                                <div class="col-sm-5 text-right">
                                    <select id="select_dash_2" class="selectpicker show-menu-arrow pr-4" data-style="btn-simple btn-github" data-width="50%">
                                        @for($mes_imprimir=0; $mes_imprimir<3; $mes_imprimir++)
                                            <option value="{{$mes_imprimir}}">{{$year - $mes_imprimir}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                
                                    <div class="chart-area_3 mt-1 pl-5 pr-2 mr-5">
                                        <canvas id="CountryChart3"></canvas>
                                    </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="tab-pane" id="history">
            <div class="row mr-0 ml-0">
                <div class="card mb-3 card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="statistics">
                                    <div class="card-body pt-0 pb-0 text-left">
                                        <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('Islas') }}</h6>
                                        <h3 class="title mt-0 mb-0">{{ count($station->islands) }}</h3>
                                        <a href="{{ route('islands.index', $station) }}" class="badge badge-success mt-0 mb-0">
                                            {{ __('Agregar') }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="statistics">
                                    <div class="card-body pt-0 pb-0 text-left">
                                        <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('Ventas totales') }}</h6>
                                        <h3 class="title mb-0">{{ count($station->sales) }}</h3>
                                        @if ($sales > 0)
                                            <a class="text-success mt-0 mb-0">+{{ $sales }} %</a>
                                        @elseif($sales == 0)
                                            <a class="text-muted mt-0 mb-0">{{ $sales }} %</a>
                                        @else
                                            <a class="text-danger mt-0 mb-0">{{ $sales }} %</a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="statistics">
                                    <div class="card-body pt-0 pb-0 text-left">
                                        <h6 class="card-subtitle mt-0 mb-0 text-muted">{{ __('Litros vendidos') }}</h6>
                                        <h3 class="title mb-0">{{ $station->sales->where('liters', '>', 0)->sum('liters') }}</h3>
                                        @if ($liters > 0)
                                            <a class="text-success mt-0 mb-0">
                                                <i class="material-icons md-18">
                                                    arrow_circle_up
                                                </i>
                                                +{{ $liters }}%
                                            </a>
                                        @elseif($liters == 0)
                                            <a class="text-muted mt-0 mb-0">{{ $liters }} %</a>
                                        @else
                                            <a class="text-danger mt-0 mb-0">
                                                <i class="material-icons md-18">
                                                    arrow_circle_down
                                                </i>
                                                {{ $liters }}%
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="">
                                    <div class="card-body pt-0 pb-0 text-left">
                                        <h6 class="card-subtitle mt-0 mb-0 text-muted">Abonos pendientes</h6>
                                        <h3 class="title mt-0 mb-0">
                                            {{ count($station->deposits->where('status', 1)) }}
                                        </h3>
                                        <a href="{{ route('balances.index', $station) }}" class="badge badge-success mt-0 mb-0">
                                            Autorizar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <div class="card card-chart">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-sm-4 text-left">
                                    <h3 class="title mb-0">Ventas totales</h3>
                                    <h4 class="card-title mb-2">Litros</h4>
                                </div>
                                <div class="col-sm-8">
                                    <div class="btn-group btn-group-toggle mx-auto d-block" data-toggle="buttons">
                                        <label class="btn btn-sm btn-success btn-simple active" id="0">
                                            <input type="radio" name="options" checked>
                                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Magna</span>
                                            <span class="d-block d-sm-none">MA</span>
                                        </label>
                                        <label class="btn btn-sm btn-danger btn-simple" id="1">
                                            <input type="radio" class="d-none d-sm-none" name="options">
                                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Premium</span>
                                            <span class="d-block d-sm-none">PR</span>
                                        </label>
                                        <label class="btn btn-sm btn-dark btn-simple btn-tumblr" id="2">
                                            <input type="radio" class="d-none" name="options">
                                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Diésel</span>
                                            <span class="d-block d-sm-none">DI</span>
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
                            <div class="chart-area_2">
                                <canvas id="chartBig1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 pl-0">
                    <div class="row">
                        <div class="col-6 pr-1">
                            <div class="card card-chart mb-2">
                                <div class="card-body text-center">
                                    <div class="btn btn-success btn-fab btn-icon btn-round">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>
                                    <h6 class="card-subtitle mt-1 mb-2 text-muted">Despachadores</h6>
                                    <h3 class="title mb-0">{{ count($station->dispatchers) }}</h3>
                                </div>
                                <button class="btn btn-success ml-0 mr-0 mt-0 mb-0" onclick="window.location='{{ route('dispatcher.index', $station) }}'">
                                    {{ __('Ver más') }}
                                </button>
                            </div>
                        </div>
                        <div class="col-6 pl-1">
                            <div class="card card-chart mb-2">
                                <div class="card-body text-center">
                                    <button class="btn btn-success btn-fab btn-icon btn-round">
                                        <i class="tim-icons icon-time-alarm"></i>
                                    </button>
                                    <h6 class="card-subtitle mt-1 mb-2 text-muted">Turnos</h6>
                                    <h3 class="title mb-0">{{ count($station->schedules) }}</h3>
                                </div>
                                <button class="btn btn-success ml-0 mr-0 mt-0 mb-0" onclick="window.location='{{ route('schedules.index', $station) }}'">
                                    {{ __('Ver más') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row pl-3 pr-3">
                        <div class="card card-chart">
                            <div class="card-header ">
                                <h5 class="card-category">Ventas totales por producto</h5>
                                <h3 class="card-title"></h3>
                            </div>
                            <div class="card-body mt-3 mr-0 ml-0 pl-0 pr-0">
                                <div class="chart-area mr-0 ml-0 pl-0 pr-0">
                                    <canvas id="chartLineGreen" class="mr-0 ml-0 pl-0 pr-0"></canvas>
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
    <script src="{{ asset('white') }}/js/plugins/chartjs.min.js"></script>
    <script>
        function initDashboardPageCharts() {

            var meses = @json($station_show['meses_largos']);
            var vales_meses = @json($station_show['vales_meses']);
            var tickets_meses = @json($station_show['tickets_meses']);

            gradientChartOptionsConfigurationWithTooltipBlue = {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },

                tooltips: {
                    backgroundColor: '#f5f5f5',
                    titleFontColor: '#333',
                    bodyFontColor: '#666',
                    bodySpacing: 4,
                    xPadding: 12,
                    mode: "nearest",
                    intersect: 0,
                    position: "nearest"
                },
                responsive: true,
                scales: {
                    yAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(29,140,248,0.0)',
                            zeroLineColor: "transparent",
                        },
                        ticks: {
                            suggestedMin: 60,
                            suggestedMax: 125,
                            padding: 20,
                            fontColor: "#2380f7"
                        }
                    }],

                    xAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(29,140,248,0.1)',
                            zeroLineColor: "transparent",
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#2380f7"
                        }
                    }]
                }
            };

            gradientChartOptionsConfigurationWithTooltipPurple = {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },

                tooltips: {
                    backgroundColor: '#f5f5f5',
                    titleFontColor: '#333',
                    bodyFontColor: '#666',
                    bodySpacing: 4,
                    xPadding: 12,
                    mode: "nearest",
                    intersect: 0,
                    position: "nearest"
                },
                responsive: true,
                scales: {
                    yAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(29,140,248,0.0)',
                            zeroLineColor: "transparent",
                        },
                        ticks: {
                            suggestedMin: 60,
                            suggestedMax: 125,
                            padding: 20,
                            fontColor: "#9a9a9a"
                        }
                    }],

                    xAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(225,78,202,0.1)',
                            zeroLineColor: "transparent",
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#9a9a9a"
                        }
                    }]
                }
            };

            gradientChartOptionsConfigurationWithTooltipOrange = {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: '#f5f5f5',
                    titleFontColor: '#333',
                    bodyFontColor: '#666',
                    bodySpacing: 4,
                    xPadding: 12,
                    mode: "nearest",
                    intersect: 0,
                    position: "nearest"
                },
                responsive: true,
                scales: {
                    yAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(29,140,248,0.0)',
                            zeroLineColor: "transparent",
                        },
                        ticks: {
                            suggestedMin: 50,
                            suggestedMax: 110,
                            padding: 20,
                            fontColor: "#ff8a76"
                        }
                    }],

                    xAxes: [{
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(220,53,69,0.1)',
                            zeroLineColor: "transparent",
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "#ff8a76"
                        }
                    }]
                }
            };

            gradientChartOptionsConfigurationWithTooltipGreen = {
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    align: 'start',
                    position: 'bottom',
                    boxWidth: 5,
                    shape: 'seriesType',
                },
                tooltips: {
                    backgroundColor: '#f5f5f5',
                    titleFontColor: '#333',
                    bodyFontColor: '#666',
                    bodySpacing: 4,
                    xPadding: 12,
                    mode: "nearest",
                    intersect: 0,
                    position: "nearest"
                },
                responsive: true,
                scales: {
                    yAxes: [{
                        type: 'category',
                        align: 'start',
                        gridLines: {
                            drawBorder: true,
                            color: 'rgba(29,140,248,0.0)',
                            zeroLineColor: "transparent",
                        },
                        ticks: {
                            display: false,
                            align: 'start',
                            suggestedMin: 50,
                            suggestedMax: 125,
                            padding: 20,
                            fontColor: "#9e9e9e",
                            beginAtZero: true,
                        }
                    }],

                    xAxes: [{
                        align: 'start',
                        barPercentage: 1.6,
                        gridLines: {
                            drawBorder: false,
                            color: 'rgba(0,242,195,0.1)',
                            zeroLineColor: "transparent",
                        },
                        ticks: {
                            display: false,
                            padding: 20,
                            fontColor: "#9e9e9e",
                            beginAtZero: true
                        }
                    }]
                }
            };


            gradientBarChartConfiguration = {
            maintainAspectRatio: false,
            legend: {
                display: true,
                align:'center',
                position:'left',    
            },

            tooltips: {
                backgroundColor: '#f5f5f5',
                titleFontColor: '#333',
                bodyFontColor: '#666',
                bodySpacing: 4,
                xPadding: 12,
                mode: "nearest",
                intersect: 0,
                position: "nearest"
            },
            responsive: true,
            scales: {
                yAxes: [{

                gridLines: {
                    drawBorder: false,
                    color: 'rgba(29,140,248,0.1)',
                    zeroLineColor: "transparent",
                },
                ticks: {
                    suggestedMin: 60,
                    suggestedMax: 120,
                    padding: 30,
                    fontColor: "#9e9e9e"
                }
                }],

                xAxes: [{

                gridLines: {
                    drawBorder: false,
                    color: 'rgba(29,140,248,0.1)',
                    zeroLineColor: "transparent",
                },
                ticks: {
                    padding: 20,
                    fontColor: "#9e9e9e"
                }
                }]
            }
            };

            // grafica de pastel
            var ctxGreen = document.getElementById("chartLineGreen").getContext("2d");

            var data = {
                labels: [
                    'Magna',
                    'Premium',
                    'Diesel'
                ],
                datasets: [{
                    backgroundColor: [
                        'rgb(7, 120, 1)',
                        'rgb(217, 0, 4)',
                        'rgb(0, 3, 0)',
                    ],
                    borderColor: '#ffffff',
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
                    data: [{{$total_magna}}, {{$total_premium}}, {{$total_diesel}}],
                }],
            };

            var myChart = new Chart(ctxGreen, {
                type: 'doughnut',
                data: data,
                options: gradientChartOptionsConfigurationWithTooltipGreen
            });



            var chart_labels = ['ene'];
            var chart_data = [12];


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
                var chart_data = [12];
                var data = myChartData.config.data;
                data.datasets[0].data = chart_data;
                data.datasets[0].borderColor = '#e0000c';
                data.datasets[0].pointBackgroundColor = '#fa0000';
                data.labels = chart_labels;
                myChartData.update();
            });

            $("#2").click(function() {
                var chart_data = [14];
                var data = myChartData.config.data;
                data.datasets[0].data = chart_data;
                data.datasets[0].borderColor = '#0a0a0a';
                data.datasets[0].pointBackgroundColor = '#5c5c5c';
                data.labels = chart_labels;
                myChartData.update();
            });

            $("#3").click(function() {
                var chart_data = [2];
                var data = myChartData.config.data;
                data.datasets[0].data = chart_data;
                data.datasets[0].borderColor = '#3b3b3b';
                data.datasets[0].pointBackgroundColor = '#7d7d7d';
                data.labels = chart_labels;
                myChartData.update();
            });
            

            /*---------------------------- */
            var ctxL = document.getElementById("chartBig1L").getContext('2d');

            var gradientStroke = ctxL.createLinearGradient(0, 230, 0, 50);

            gradientStroke.addColorStop(1.0, 'rgba(255, 255, 255,0.2)');
            
            gradientStroke.addColorStop(0.5, 'rgba(255, 255, 255,0.05)');
            
            gradientStroke.addColorStop(0.0, 'rgba(255, 255, 255,0.0)');  
            //purple colors
            var config = {
                type: 'line',
                data: {
                    labels:@json($station_show['meses']),
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
                        data: @json($station_show['magna']),
                    }]
                },
                options: gradientChartOptionsConfigurationWithTooltipPurple
            };

            var myChartDataL = new Chart(ctxL, config);

            $("#4").click(function() {
                var data = myChartDataL.config.data;
                data.datasets[0].data = @json($station_show['magna']);
                data.datasets[0].borderColor = '#00c907';
                data.datasets[0].pointBackgroundColor = '#007d04';
                myChartDataL.update();
            });

            $("#5").click(function() {
                var data = myChartDataL.config.data;
                data.datasets[0].data = @json($station_show['premium']);
                data.datasets[0].borderColor = '#e0000c';
                data.datasets[0].pointBackgroundColor = '#fa0000';
                myChartDataL.update();
            });

            $("#7").click(function() {
                @php
                    $datos1 = $station_show['magna'];
                    $datos2 = $station_show['premium'];

                    $total = array();

                    for($i = 0; $i < 12; $i++) {
                        $total[] = $datos1[$i] + $datos2[$i];
                    }

                @endphp
                var data = myChartDataL.config.data;
                data.datasets[0].data = @json($total);
                data.datasets[0].borderColor = '#3b3b3b';
                data.datasets[0].pointBackgroundColor = '#7d7d7d';
                myChartDataL.update();
            });
            const total_val = vales_meses[0].reduce((a, b) => a + b);
            document.getElementById("valesTotalH3").innerHTML = "Total de vales entregados: "+total_val;
            var colors = ["#8e181a", "#b3191c", "#d11d27","#e1363a", "#e85763", "#ec7a85","#f0a0b0", "#f8ccd7", "#ff8080", "#f00", "#c00", "#330000"];
            var ctxL2 = document.getElementById("CountryChart").getContext("2d");

            var gradientStroke = ctxL2.createLinearGradient(0, 230, 0, 50);

            gradientStroke.addColorStop(1, 'rgba(248, 29, 29,1.0)');
            gradientStroke.addColorStop(0.4, 'rgba(248, 29, 29,0.4)');
            gradientStroke.addColorStop(0, 'rgba(248, 29, 29,0)'); 

            var configL2 ={
                type: 'bar',
                responsive: true,
                data: {
                    labels:[''],
                    datasets: [
                       @for($i=0; $i<count($station_show['meses_largos']); $i++)
                        {
                            label: '{{$station_show['meses_largos'][$i]}}: {{$station_show['vales_meses'][0][$i]}}                                                 ',
                            fill: true,
                            backgroundColor: colors[{{$i}}],
                            hoverBackgroundColor: colors[{{$i}}],
                            borderColor: '#ffffff',
                            borderWidth: 2,
                            borderDash: [],
                            borderDashOffset: 0.0,
                            data: [{{$station_show['vales_meses'][0][$i]}}],
                        },
                        @endfor
                    ]
                },
                options: gradientBarChartConfiguration
            }

            var myChartL2 = new Chart(ctxL2, configL2);

            $( "#select_dash_1" ).change(function() {
                php_variable_1 = document.getElementById("select_dash_1").value;
                const total1 = vales_meses[php_variable_1].reduce((a, b) => a + b);
                document.getElementById("valesTotalH3").innerHTML = "Total de vales entregados: "+total1;
                myChartL2.destroy();
                myChartL2 = new Chart(ctxL2, configL2.datasets = {
                    type: 'bar',
                    responsive: true,
                    data: {
                        labels:[
                            '',
                        ],
                        datasets: [
                            @for($j=0; $j<count($station_show['meses_largos']); $j++)
                                {
                                    label: meses[{{$j}}]+':'+vales_meses[php_variable_1][{{$j}}]+'                                                 ',
                                    fill: true,
                                    backgroundColor: colors[{{$j}}],
                                    hoverBackgroundColor: colors[{{$j}}],
                                    borderColor: '#ffffff',
                                    borderWidth: 2,
                                    borderDash: [],
                                    borderDashOffset: 0.0,
                                    data:[vales_meses[php_variable_1][{{$j}}]],
                                },
                            @endfor
                            
                        ]
                    },
                    options: gradientBarChartConfiguration
                });
            });


            const totaltick = tickets_meses[0].reduce((a, b) => a + b);
            document.getElementById("ticketsTotalH3").innerHTML = "Total de tickets entregados: "+totaltick;
            var colors3 = ["#030", "#004d00", "#006600","#008000", "#009900", "#00b300","#00cc00", "#0c0", "#0f0", "#1aff1a", "#66ff66", "#cfc"];
            var ctxL3 = document.getElementById("CountryChart3").getContext("2d");

            var gradientStroke = ctxL3.createLinearGradient(0, 230, 0, 50);

            gradientStroke.addColorStop(1, 'rgba(248, 29, 29,1.0)');
            gradientStroke.addColorStop(0.4, 'rgba(248, 29, 29,0.4)');
            gradientStroke.addColorStop(0, 'rgba(248, 29, 29,0)'); 

            var configL3 ={
                type: 'bar',
                responsive: true,
                data: {
                    labels:[''],
                    datasets: [
                       @for($i=0; $i<count($station_show['meses_largos']); $i++)
                        {
                            label: '{{$station_show['meses_largos'][$i]}}: {{$station_show['tickets_meses'][0][$i]}}                                                  ',
                            fill: true,
                            backgroundColor: colors3[{{$i}}],
                            hoverBackgroundColor: colors3[{{$i}}],
                            borderColor: '#ffffff',
                            borderWidth: 2,
                            borderDash: [],
                            borderDashOffset: 0.0,
                            data: [{{$station_show['tickets_meses'][0][$i]}}],
                        },
                        @endfor
                    ]
                },
                options: gradientBarChartConfiguration
            }

            var myChartL3 = new Chart(ctxL3, configL3);

            $( "#select_dash_2" ).change(function() {
                php_variable_2 = document.getElementById("select_dash_2").value;
                const total2 = tickets_meses[php_variable_2].reduce((a, b) => a + b);
                document.getElementById("ticketsTotalH3").innerHTML = "Total de tickets entregados: "+total2;
                myChartL3.destroy();
                myChartL3 = new Chart(ctxL3, configL3.datasets = {
                    type: 'bar',
                    responsive: true,
                    data: {
                        labels:[
                            '',
                        ],
                        datasets: [
                            @for($j=0; $j<count($station_show['meses_largos']); $j++)
                                {
                                    label: meses[{{$j}}]+':'+tickets_meses[php_variable_2][{{$j}}]+'                                                  ',
                                    fill: true,
                                    backgroundColor: colors3[{{$j}}],
                                    hoverBackgroundColor: colors3[{{$j}}],
                                    borderColor: '#ffffff',
                                    borderWidth: 2,
                                    borderDash: [],
                                    borderDashOffset: 0.0,
                                    data:[tickets_meses[php_variable_2][{{$j}}]],
                                },
                            @endfor
                            
                        ]
                    },
                    options: gradientBarChartConfiguration
                });
            });
            

        };
        $(document).ready(function() {
            initDashboardPageCharts();
            $('.carousel').carousel();
        });

    </script>
@endpush