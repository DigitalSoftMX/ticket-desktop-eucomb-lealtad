@extends('layouts.app', ['pageSlug' => 'Despachadores', 'titlePage' => __('Gestión de despachadores')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 mx-auto d-block mt-3">
                    <form method="post" 
                        @if ($station->id != null) 
                            action="{{ route('dispatcher.store', $station) }}" 
                        @else
                            action="{{ route('dispatchers.store') }}" 
                        @endif
                        autocomplete="off" class="form-horizontal">
                        @method('post')
                        @include('partials._dispatchers',[$message='Agregar despachador',$btnText='Guardar'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
