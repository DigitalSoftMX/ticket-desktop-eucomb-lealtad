<div class="card card-chart">
    <div class="card-header text-left m-0 p-0 pt-4 pl-5 pb-0">
        <h4 class="titlee text-muted font-weight-bold p-0 m-0">
            {{ $title }}
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