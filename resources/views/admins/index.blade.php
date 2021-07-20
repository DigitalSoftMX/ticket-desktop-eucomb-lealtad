@extends('layouts.app', ['pageSlug' => 'Administradores', 'titlePage' => __('Gestión de administradores')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Administradores') }}</h4>
                            <p class="card-category">
                                {{ __('Aquí puedes administrar a los administradores.') }}
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('admins.create') }}"
                                        class="btn btn-sm btn-primary">{{ __('Agregar Administrador') }}</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="usuarios">
                                    <thead class=" text-primary">
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('Apellidos') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Teléfono') }}</th>
                                        <th>{{ __('Rol') }}</th>
                                        <th>{{ __('Estación') }}</th>
                                        <th>{{ __('Fecha de Alta') }}</th>
                                        <th class="text-right">{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($admins as $admin)
                                            <tr>
                                                <td>{{ $admin->name }}</td>
                                                <td>{{ $admin->first_surname }} {{ $admin->second_surname }}</td>
                                                <td>{{ $admin->email }}</td>
                                                <td>{{ $admin->phone }}</td>
                                                <td>{{ $admin->roles[0]->name }}</td>
                                                <td>{{ $admin->admin->station->name ?? '-' }}</td>
                                                <td>{{ $admin->created_at ? $admin->created_at->format('d/m/Y') : '-' }}
                                                </td>
                                                <td class="td-actions text-right">
                                                    <a rel="tooltip" class="btn btn-info btn-icon btn-link"
                                                        href="{{ route('invited.show', $admin) }}">
                                                        <i class="tim-icons icon-zoom-split"></i>
                                                    </a>
                                                    @if ($admin->roles[0]->id != auth()->user()->roles[0]->id)
                                                        <form action="{{ route('admins.destroy', $admin) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <a rel="tooltip" class="btn btn-success btn-link"
                                                                href="{{ route('admins.edit', $admin) }}"
                                                                data-original-title="" title="">
                                                                <i class="tim-icons icon-pencil"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-link"
                                                                data-original-title="" title=""
                                                                onclick="confirm('{{ __('¿Estás seguro de que deseas eliminar este administrador?') }}') ? this.parentElement.submit() : ''">
                                                                <i class="tim-icons icon-trash-simple"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
