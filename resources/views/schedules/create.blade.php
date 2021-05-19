@extends('layouts.app', ['pageSlug' => 'Turnos', 'titlePage' => __('Gestión de turnos de la estación')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 mx-auto d-block mt-3">
                    <form method="post" action="{{ route('schedules.store', $station) }}" autocomplete="off"
                        class="form-horizontal">
                        @method('post')
                        @include('partials._schedules',[$btnText='Guardar',$message='Agregar Turno'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
