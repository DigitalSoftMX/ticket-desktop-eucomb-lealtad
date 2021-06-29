<div class="card">
    <div class="row card-body">
        <div class="col-sm-5 p-3">
            <div class="text-left">
                <div class="row">
                    <div class="col-sm-2 text-right"></div>
                    <div class="col-sm-5 text-center">
                        <select id="dateone" class="dateone selectpicker show-menu-arrow" data-style="btn-simple btn-github" data-width="60%">
                            @for($md=0; $md<$num_months; $md++)
                                <option value="{{($num_months - $md)}}">{{$mounts[$md]}} {{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-sm-5 text-center">
                        <select id="datetwo" class="datetwo selectpicker show-menu-arrow" data-style="btn-simple btn-github" data-width="60%">
                            @for($md=0; $md<$num_months; $md++)
                                <option value="{{($num_months - $md)}}">{{$mounts[$md]}} {{ ($year - 1) }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                @foreach($stations as $clave => $estacion_1)
                <div class="row">
                    <div class="col-sm-2 text-left mt-2 mb-2">
                        <a class="font-weight-bold h5 pl-3">{{ $estacion_1->abrev }}:</a>
                    </div>
                    <div class="col-sm-5 text-center mt-2 mb-2">
                        <a class="h5" id="colRed{{$clave}}">{{ number_format($chart[0][$clave],2) }}L</a>
                    </div>
                    <div class="col-sm-5 text-center mt-2 mb-2">
                        <a class="h5" id="colGreen{{$clave}}">{{  number_format($chart[1][$clave],2) }}L</a>
                    </div>
                </div>
                @endforeach   
            </div>
        </div>  
        <div class="col-sm-7 card-chart p-3">
            <div class="chart-area_2 p-3">
                <canvas id="chartBig1LL"></canvas>
            </div>
        </div>
    </div>
</div>

@push('dash')

    var ctxLL = document.getElementById("chartBig1LL").getContext('2d');
    var gradientStrokeLL = ctxLL.createLinearGradient(227, 53, 0, 0);
    var configLL = {
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
                            backgroundColor: gradientStrokeLL,
                            borderColor: '#c91100',
                            borderWidth: 2,
                            borderDash: [],
                            borderDashOffset: 0.0,
                            pointBackgroundColor: '#d10300',
                            pointBorderColor: 'rgba(255,255,255,0)',
                            pointHoverBackgroundColor: '#d34646',
                            pointBorderWidth: 20,
                            pointHoverRadius: 4,
                            pointHoverBorderWidth: 15,
                            pointRadius: 4,
                            data: @json($chart[0]),
                        }, {
                            label: "Total de litros al mes",
                            fill: true,
                            backgroundColor: gradientStrokeLL,
                            borderColor: '#00c907',
                            borderWidth: 2,
                            borderDash: [],
                            borderDashOffset: 0.0,
                            pointBackgroundColor: '#007d04',
                            pointBorderColor: 'rgba(255,255,255,0)',
                            pointHoverBackgroundColor: '#48d143',
                            pointBorderWidth: 20,
                            pointHoverRadius: 4,
                            pointHoverBorderWidth: 15,
                            pointRadius: 4,
                            data: @json($chart[1]),
                        }]
                    },
                    options: gradientChartOptionsConfigurationWithTooltipPurple
                };
    var myChartDataLL = new Chart(ctxLL, configLL);

    // selects

    const selectElement = document.querySelector('#dateone');
    const selectElementTwo = document.querySelector('#datetwo');

    

    selectElement.addEventListener('change', (event) => {
        // array
        var valuesDobleOne = [];
        var valuesDobleTwo = [];

        const resultado = event.target.value;
        const tow = document.getElementById("datetwo").value;
        const Http = new XMLHttpRequest();
        const url = 'litersMountYears?mountOne='+resultado+'&mountTwo='+tow;
        Http.open("GET", url);
        Http.send();

        Http.onreadystatechange = (e) => {
            if (Http.readyState == 4 && Http.status == 200) {
                var status = JSON.parse(Http.responseText);
                for(i=0; i < status['chartYears'][0].length; i++){
                    document.getElementById("colRed"+i).innerHTML = status['chartYears'][0][i]+'L';
                    document.getElementById("colGreen"+i).innerHTML = status['chartYears'][1][i]+'L';

                    valuesDobleOne.push(parseFloat(Number(status['chartYears'][0][i].replace(/[^0-9.-]+/g,""))));
                    valuesDobleTwo.push(parseFloat(Number(status['chartYears'][1][i].replace(/[^0-9.-]+/g,""))));
                    
                }

                var data = myChartDataLL.config.data;
                data.datasets[0].data = valuesDobleOne;
                data.datasets[1].data = valuesDobleTwo;
                myChartDataLL.update();
            }
        }
    });

    selectElementTwo.addEventListener('change', (event) => {
        // array
        var valuesDobleOne = [];
        var valuesDobleTwo = [];

        const resultado = event.target.value;
        const one = document.getElementById("dateone").value;
        const Http = new XMLHttpRequest();
        const url = 'litersMountYears?mountOne='+one+'&mountTwo='+resultado;
        Http.open("GET", url);
        Http.send();

        Http.onreadystatechange = (e) => {
            if (Http.readyState == 4 && Http.status == 200) {
                var status = JSON.parse(Http.responseText);
                for(i=0; i < status['chartYears'][0].length; i++){
                    document.getElementById("colRed"+i).innerHTML = status['chartYears'][0][i]+'L';
                    document.getElementById("colGreen"+i).innerHTML = status['chartYears'][1][i]+'L';
                    
                    valuesDobleOne.push(parseFloat(Number(status['chartYears'][0][i].replace(/[^0-9.-]+/g,""))));
                    valuesDobleTwo.push(parseFloat(Number(status['chartYears'][1][i].replace(/[^0-9.-]+/g,""))));
                }

                var data = myChartDataLL.config.data;
                data.datasets[0].data = valuesDobleOne;
                data.datasets[1].data = valuesDobleTwo;
                myChartDataLL.update();
            }
        }
    });
    
@endpush
