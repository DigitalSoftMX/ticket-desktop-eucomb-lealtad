@extends('layouts.app', ['pageSlug' => 'Referidos', 'titlePage' => __('Gestión de membresias con
beneficio')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Membresias asociadas') }}</h4>
                            <p class="card-category">
                                {{ __('Aquí puedes administrar a las membresias asociadas.') }}
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                <a href="{{ route('references.create') }}"
                                    class="btn btn-sm btn-primary">{{ __('Activar Membresia') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable table-sm table-no-bordered table-hover white-datatables"
                                    cellspacing="0" width="100%" id="usuarios">
                                    <thead class=" text-primary">
                                        <th>{{ __('Membresía') }}</th>
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('Apellidos') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Puntos por beneficio') }}</th>
                                        <th>{{ __('Benefactores') }}</th>
                                        <th class="text-right">{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($clients as $client)
                                            <tr>
                                                <td>{{ $client->user->username }}</td>
                                                <td>{{ $client->user->name }}</td>
                                                <td>{{ $client->user->first_surname }}
                                                    {{ $client->user->second_surname }}</td>
                                                <td>{{ $client->user->email }}</td>
                                                <td>{{ $client->user->qrs->sum('points') }}</td>
                                                <td>{{ $client->user->hosts->count() }}</td>
                                                </td>
                                                <td class="td-actions text-right">
                                                    <form action="{{ route('references.update', $client->user) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('put')
                                                        <a rel="tooltip" class="btn btn-success btn-link"
                                                            href="{{ route('references.show', $client->user) }}"
                                                            data-original-title="" title="">
                                                            <i class="tim-icons icon-pencil"></i>
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-{{ $client->active == 0 ? 'success' : 'danger' }} btn-link"
                                                            data-original-title="" title=""
                                                            onclick="confirm('{{ __('¿Estás seguro de que deseas ' . ($client->active == 0 ? 'activar' : 'desactivar') . ' este cliente?') }}') ? this.parentElement.submit() : ''">
                                                            <span class="material-icons-outlined">
                                                                {{ $client->active == 0 ? 'done_outline' : 'close' }}
                                                            </span>
                                                        </button>
                                                    </form>
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
