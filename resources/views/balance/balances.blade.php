<thead class="text-primary">
    <th>{{ __('Membresia') }}</th>
    <th>{{ __('Cantidad') }}</th>
    <th>{{ __('Folio') }}</th>
    <th>{{ __('Fecha de solicitud') }}</th>
    <th>{{ __('Estación') }}</th>
    @if (auth()->user()->roles()->first()->id != 7)
        <th class="text-center">{{ __('Acciones') }}</th>
    @endif
</thead>
<tbody>
    @foreach ($deposits as $deposit)
        @if ($deposit->status == $status)
            <tr>
                <td>{{ $deposit->client->user->username }}</td>
                <td>{{ $deposit->balance }}</td>
                <td>
                    @if (Illuminate\Support\Facades\File::exists('storage/' . $deposit->image_payment))
                        <img src="{{ asset('storage/' . $deposit->image_payment) }}" alt="" height="40"
                            onclick="imagen_mostrar('{{ asset('storage/' . $deposit->image_payment) }}');"
                            data-toggle="modal" data-target="#exampleModalLong" title="click para ampliar.">
                    @else
                        <img src="{{ asset('api') . '/' . $deposit->image_payment }}" alt="" height="40"
                            onclick="imagen_mostrar('{{ asset('api') . '/' . $deposit->image_payment }}');"
                            data-toggle="modal" data-target="#exampleModalLong" title="click para ampliar.">
                    @endif
                </td>
                <td>{{ $deposit->created_at }}</td>
                <td>{{ $deposit->station->name }}</td>
                @if (auth()->user()->roles()->first()->id != 7)
                    <td class="td-actions text-center">
                        <div class="row justify-content-center">
                            @switch($status)
                                @case(1)
                                    <div class="col-1 float-right">
                                        <form action="{{ route('balance.accept', $deposit) }}" method="post">
                                            @csrf
                                            <button type="button" class="btn btn-success btn-link"
                                                title="Autorizar el depósito"
                                                onclick="confirm('{{ __('¿Estás seguro de que deseas confirmar el abono?') }}') ? this.parentElement.submit() : ''">
                                                <span class="material-icons-outlined">done</span>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-1 float-right">
                                        <button type="button" class="btn btn-danger btn-link" title="Denegar el depósito"
                                            data-toggle="modal" data-target=".deny{{ $deposit->id }}">
                                            <span class="material-icons-outlined">close </span>
                                        </button>
                                        <form action="{{ route('balance.denny', $deposit->id) }}" method="post">
                                            @csrf
                                            @include('balance.deny',[$ideposit=$deposit->id])
                                        </form>
                                    </div>
                                @break
                                @case(2)
                                    <button type="button" class="btn btn-info btn-link" title="Denegar el depósito"
                                        data-toggle="modal"
                                        data-target=".deny{{ "{$deposit->id}pending{$deposit->status}" }}">
                                        <span class="material-icons-outlined">undo</span>
                                    </button>
                                    <form action="{{ route('balance.denny', [$deposit->id, $deposit->status]) }}"
                                        method="post">
                                        @csrf
                                        @include('balance.deny',[$ideposit="{$deposit->id}pending{$deposit->status}",$estado=$deposit->status])
                                    </form>
                                @break
                                @case(3)
                                    <div class="col-1 float-right mx-1">
                                        <button type="button" class="btn btn-info btn-link" title="Ver motivo de negación"
                                            data-toggle="modal" data-target=".deny{{ $deposit->id }}">
                                            <span class="material-icons-outlined">visibility</span>
                                        </button>
                                        @include('balance.deny',[$ideposit=$deposit->id])
                                    </div>
                                    <div class="col-1 float-right mx-1">
                                        <form action="{{ route('balance.accept', $deposit) }}" method="post">
                                            @csrf
                                            <button type="button" class="btn btn-success btn-link"
                                                title="Autorizar el depósito"
                                                onclick="confirm('{{ __('¿Estás seguro de que deseas confirmar el abono?') }}') ? this.parentElement.submit() : ''">
                                                <span class="material-icons-outlined">done</span>
                                            </button>
                                        </form>
                                    </div>
                                @break
                            @endswitch
                        </div>
                    </td>
                @endif
            </tr>
        @endif
    @endforeach
</tbody>
