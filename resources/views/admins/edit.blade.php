@extends('layouts.app', ['pageSlug' => 'Administradores', 'titlePage' => __('Gestión de administradores')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 mx-auto d-block mt-3">
                    <form method="post" action="{{ route('admins.update', $admin) }}" autocomplete="off"
                        class="form-horizontal">
                        @method('patch')
                        @include('partials._admins',[$message='Editar administrador',$button='Actualizar'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
