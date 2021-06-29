<div class="card overflowCards card-chart">
    <div class="card-header">
        <div class="row mt-1 mb-0">
            <div class="col-sm-10 pt-2 text-left">
                <h3 class="card-subtitle text-muted">VENTAS TOTALES POR ESTACIÓN</h3>
                <!--h2 class="card-title mb-5">Litros</h2-->
            </div>
            <div class="col-sm-2 text-center pl-3">
                <select id="select_dash_1" class="selectpicker show-menu-arrow float-start" data-style="btn-simple btn-github" data-width="95%">
                    @for($i=0; $i<$number; $i++)
                        <option value="{{$i}}">{{$options[$i]}}</option>
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

@push('dash')
    var liters_yearM = @json($chart);
    document.getElementById("ventasTotalH4").innerHTML = "LITROS TOTALES VENDIDOS: {{ number_format(array_sum($chart[0]),2) }}L";

    var ctxL = document.getElementById("chartBig1L").getContext('2d');
    var gradientStroke = ctxL.createLinearGradient(0, 230, 0, 50);
    gradientStroke.addColorStop(1.0, 'rgba(17, 196, 14,0.2)');
    gradientStroke.addColorStop(0.5, 'rgba(17, 196, 14,0.05)');
    gradientStroke.addColorStop(0.0, 'rgba(17, 196, 14,0.0)');  

    //purple colors
    var config = {
        type: 'line',
        data: {
            labels:[
            @foreach($stations as $station)
                '{{$station->abrev}}',
            @endforeach
            ],
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
                data: @json($chart[0]),
            }]
        },
        options: gradientChartOptionsConfigurationWithTooltipPurple
    };

    var myChartDataL = new Chart(ctxL, config);

    $( "#select_dash_1" ).change(function() {
        var php_variable = document.getElementById("select_dash_1").value;
        const total = liters_yearM[php_variable].reduce((a, b) => a + b);
        document.getElementById("ventasTotalH4").innerHTML = "LITROS TOTALES VENDIDOS: "+ total.toFixed(2)+"L";
        var chart_dataL = chart[php_variable];
        var data = myChartDataL.config.data;
        data.datasets[0].data = chart_dataL;
        myChartDataL.update();
    });

@endpush