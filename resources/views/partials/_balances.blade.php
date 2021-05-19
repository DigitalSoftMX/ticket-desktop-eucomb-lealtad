<thead class=" text-primary">
    <th>{{ __('ID') }}</th>
    <th>{{ __('Membresia') }}</th>
    <th>{{ __('Cantidad') }}</th>
    <th>{{ __('Folio') }}</th>
    <th>{{ __('Fecha de solicitud') }}</th>
    <th>{{ __('Estación') }}</th>
    @if (auth()->user()->roles()->first()->id != 7)
        @if ($status != 2)
            <th class="text-right">{{ __('Acciones') }}</th>
        @endif
    @endif
</thead>
<tbody>
    @foreach ($payments as $payment)
        @if ($payment->status == $status)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payment->client->user->username }}</td>
                <td>{{ $payment->balance }}</td>
                <td>
                    @if (Illuminate\Support\Facades\File::exists('storage/' . $payment->image_payment))
                        <img src="{{ asset('storage/' . $payment->image_payment) }}" alt="" height="40"
                            onclick="imagen_mostrar('{{ asset('storage/' . $payment->image_payment) }}');"
                            data-toggle="modal" data-target="#exampleModalLong" title="click para ampliar.">
                    @else
                        <img src="{{ asset('api') . '/' . $payment->image_payment }}" alt="" height="40"
                            onclick="imagen_mostrar('{{ asset('api') . '/' . $payment->image_payment }}');"
                            data-toggle="modal" data-target="#exampleModalLong" title="click para ampliar.">
                    @endif
                </td>
                <td>{{ $payment->created_at }}</td>
                <td>{{ $payment->station->name }}</td>
                @if (auth()->user()->roles()->first()->id != 7)
                    @if ($status != 2)
                        <td class="td-actions text-right">
                            <div class="row float-right">
                                <div class="col-1 float-right">
                                    <form action="{{ route('balance.accept', $payment) }}" method="post">
                                        @csrf
                                        <button type="button" class="btn btn-success btn-link" data-original-title=""
                                            title=""
                                            onclick="confirm('{{ __('¿Estás seguro de que deseas confirmar el abono?') }}') ? this.parentElement.submit() : ''">
                                            <i class="tim-icons icon-check-2"></i>
                                            <div class="ripple-container"></div>
                                        </button>
                                    </form>
                                </div>
                                @if ($status == 1)
                                    <div class="col-1 float-right">
                                        <form action="{{ route('balance.denny', $payment->id) }}" method="post">
                                            @csrf
                                            <button type="button" class="btn btn-danger btn-link" data-original-title=""
                                                title=""
                                                onclick="confirm('{{ __('¿Estás seguro de que deseas denegar el abono?') }}') ? this.parentElement.submit() : ''">
                                                <i class="tim-icons icon-simple-remove"></i>
                                                <div class="ripple-container"></div>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </td>
                    @endif
                @endif
            </tr>
        @endif
    @endforeach
</tbody>
