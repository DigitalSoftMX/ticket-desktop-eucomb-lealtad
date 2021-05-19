@extends('layouts.app', ['pageSlug' => 'Despachadores', 'titlePage' => __('Gestión de despachadores')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 mx-auto d-block mt-3">
                    <form method="post" 
                        @if ($station->id != null)
                            action="{{ route('dispatcher.update', [$station, $dispatcher]) }}" 
                        @else
                            action="{{ route('dispatchers.update', $dispatcher) }}" 
                        @endif
                        autocomplete="off" class="form-horizontal">
                        @method('patch')
                        @include('partials._dispatchers')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
