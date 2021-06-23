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