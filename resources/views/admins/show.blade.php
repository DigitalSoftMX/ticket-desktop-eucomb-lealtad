@extends('layouts.app', ['pageSlug' => $estacion_dashboard ?? 'Estaciones', 'titlePage' => __($estacion_dashboard)])

@section('content')

    <div class="tab-content text-center">
        <div class="tab-pane active" id="updates">
            <div class="row mt-5">
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">Usuarios referidos</h6>
                            <h3 class="title mb-0">{{number_format($userInfoSale->user()->references()->count(),0)}}</h3>
                        </div>
                    </div>
                </div>
            
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">Total de vales entregados</h6>
                            <h3 class="title mb-0">{{number_format($userInfoSale->user()->exchanges()->count(),0)}}</h3>
                            
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">litros vendidos</h6>
                            <h3 class="title mb-0">{{ number_format($userInfoSale->user()->salesqrs()->sum('liters'), 2) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-left">
                            <h6 class="card-subtitle mt-0 mb-0 text-muted">total de tickets escaneados</h6>
                            <h3 class="title mt-0 mb-0">{{ number_format($userInfoSale->user()->salesqrs()->count(), 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card overflowCards card-chart">
                        <div class="card-header">
                            <div class="row mt-1 mb-0">
                                <div class="col-sm-10 pt-2 text-left">
                                    <h3 class="card-subtitle text-muted">VENTAS TOTALES POR ESTACIÓN</h3>
                                    <!--h2 class="card-title mb-5">Litros</h2-->
                                </div>
                                <div class="col-sm-2 text-center pl-3">
                                    <select id="select_dash_1" class="selectpicker show-menu-arrow float-start" data-style="btn-simple btn-github" data-width="95%">
                                        @for($md=0; $md<3; $md++)
                                            <option value="{{$md}}">{{$year_select[$md]}}</option>
                                        @endfor 
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-0 mb-0">
                                <div class="col-sm-5 text-left pt-3 pl-3">
                                    <h4 class="card-subtitle text-muted" id="ventasTotalH4"></h4>
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
                <div class="col-lg-4">
                    <div class="card card-chart">
                        <div class="card-header text-left m-0 p-0 pt-4 pl-5 pb-0">
                            <h4 class="titlee text-muted font-weight-bold p-0 m-0">
                               DETALLES POR ESTACIÓN
                            </h4>
                        </div>
                        <div class="card-body text-left m-0 p-0 pt-3 pb-3">
                            <div class="row m-0 pl-5 pr-5 pt-0 pb-0">
                                <div class="table-full-width table-responsive col-sm-12 m-0 mr-0 ml-0 pr-0 pl-0">
                                    <table class="table table-shopping">
                                        <tbody>
                                            @foreach($stations as $estacion_1)
                                            <tr>
                                                <td>
                                                    <p class=" card-subtitle">{{ $estacion_1->name }}</p>
                                                </td>
                                                <td class="td-actions text-right">
                                                    <a class="btn btn-danger btn-link p-0 m-0" data-original-title=""
                                                    href="{{ route('stations.show', $estacion_1) }}" rel="tooltip"
                                                        title="Ver información de la estación">
                                                        <i class="material-icons text-success">keyboard_arrow_right</i>
                                                    </a>
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
                                    <h4 class="titlee text-muted font-weight-bold p-0 m-0 pl-4 pt-2" id="ticketsTotalH4">
                                    </h4>
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

        
    </div>
    

@endsection

@push('js')
    <script>
        function initDashboardPageCharts() {
            // grafica por años
            var liters_year = @json($dashboar['liters_year']);
            var liters_mouths = @json($dashboar['liters_mouths']);
            var stations_mouths_tickets = @json($dashboar['stations_mouths_tickets']);
            var stations_mouths_exchage = @json($dashboar['stations_mouths_exchage']);

            document.getElementById("ventasTotalH4").innerHTML = "LITROS TOTALES VENDIDOS: {{ number_format(array_sum($dashboar['liters_year'][0]),2) }}L";
            var ctxL = document.getElementById("chartBig1L").getContext('2d');
            var gradientStroke = ctxL.createLinearGradient(0, 230, 0, 50);
            gradientStroke.addColorStop(1.0, 'rgba(17, 196, 14,0.2)');
            gradientStroke.addColorStop(0.5, 'rgba(17, 196, 14,0.05)');
            gradientStroke.addColorStop(0.0, 'rgba(17, 196, 14,0.0)'); 

            var config = {
                type: 'line',
                data: {
                    labels:[
                    @foreach($stations as $station)
                        '{{$station->abrev}}',
                    @endforeach
                    ],
                    datasets: [{
                        label: "Total de litros",
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
                        data: @json($dashboar['liters_year'][0]),
                    }]
                },
                options: gradientChartOptionsConfigurationWithTooltipPurple
            };

            var myChartDataL = new Chart(ctxL, config);

            $( "#select_dash_1" ).change(function() {
                var php_variable = document.getElementById("select_dash_1").value;
                const total = liters_year[php_variable].reduce((a, b) => a + b);
                document.getElementById("ventasTotalH4").innerHTML = "LITROS TOTALES VENDIDOS: "+ total.toFixed(2)+"L";
                var chart_dataL = liters_year[php_variable];
                var data = myChartDataL.config.data;
                data.datasets[0].data = chart_dataL;
                myChartDataL.update();
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

        }
        $(document).ready(function() {
          initDashboardPageCharts();
        });
    </script>
@endpush