@extends('layouts.app', ['pageSlug' => 'Turnos', 'titlePage' => __('Gestión de turnos de la estación')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 mx-auto d-block mt-3">
                    <form method="post" action="{{ route('schedules.update', [$station, $schedule]) }}" autocomplete="off"
                        class="form-horizontal">
                        @method('patch')
                        @include('partials._schedules')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
