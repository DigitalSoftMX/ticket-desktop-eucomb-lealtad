<thead class=" text-primary">
    <th>{{ __('Membresia') }}</th>
    <th>{{ __('Número de vale') }}</th>
    <th>{{ __('Estación') }}</th>
    <th>{{ __('Status') }}</th>
    <th>{{ __('Fecha de solicitud') }}</th>
    @if (auth()->user()->roles()->first()->id != 7)
        <th class="text-right">{{ __('Acciones') }}</th>
    @endif
</thead>
<tbody>
    @foreach ($exchanges as $exchange)
        @if ($exchange->status == $status)
            <tr>
                <td>{{ $exchange->client->user->username }}</td>
                <td>{{ $exchange->exchange }}</td>
                <td>{{ $exchange->station->name }}</td>
                <td>{{ $exchange->estado->name }}</td>
                <td>{{ $exchange->created_at }}</td>
                @if (auth()->user()->roles()->first()->id != 7)
                    <td class="td-actions text-right">
                        <div class="row float-right">
                            <div class="col-1 float-right">
                                <form method="post" action="{{ route($route, $exchange) }}">
                                    @csrf
                                    <button type="button" class="btn btn-success btn-link" data-original-title=""
                                        title=""
                                        onclick="confirm('{{ __('¿Estás seguro de que deseas procesar el canje?') }}') ? this.parentElement.submit() : ''">
                                        <span class="material-icons">done_outline</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                @endif
            </tr>
        @endif
    @endforeach
</tbody>
