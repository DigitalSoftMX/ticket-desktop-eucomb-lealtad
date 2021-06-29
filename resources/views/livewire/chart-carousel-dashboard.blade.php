@php
    $mi = $m;
@endphp


<div id="carouselExampleInterval" class="carousel slide m-4" data-ride="carousel" /*wire:click="$emit('postAdded')"*/>

    <div class="carousel-inner">
        @for($i= $con; $i<5; $i++)
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
                                        <a class="text-success font-weight-bold h4">{{$mounts[$mi]}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-area pl-2 pr-3">
                                    <canvas id="chartLineGreen{{$mi}}"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $mi++;
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


