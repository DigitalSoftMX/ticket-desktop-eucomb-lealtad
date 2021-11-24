<div class="modal fade deny{{ $ideposit }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    @isset($estado)
                        {{ __('Regresar al estado pendiente') }}
                    @else
                        {{ $deposit->status != 3 ? __('Denegar la solicitud') : __('Movito de negación de solicitud') }}
                    @endisset
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="form-group{{ $errors->has('deny') ? ' has-danger' : '' }} col-sm-6">
                        <label for="deny">
                            {{ isset($estado) ? __('Motivo de estado pendiente') : __('Motivo de negación') }}
                        </label>
                        <textarea class="form-control{{ $errors->has('deny') ? ' is-invalid' : '' }}" id="input-deny"
                            aria-describedby="denyHelp" name="deny" cols="30" rows="10" required
                            @if ($deposit->status == 3) readonly @endif
                            placeholder="{{ isset($estado) ? 'Escribe el motivo por el que se regresa al estado pendiente' : 'Escribe el motivo por el que se niega la solicitud' }}">{{ old('deny', $deposit->status != 1 ? $deposit->deny : '') }}</textarea>
                        @if ($errors->has('deny'))
                            <span id="deny-error" class="error text-danger" for="input-deny">
                                {{ $errors->first('deny') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                @if ($deposit->status != 3)
                    <button type="button" class="btn btn-link btn-dark mx-1"
                        data-dismiss="modal">{{ __('Cancelar') }}</button>
                    <button type="submit" class="btn btn-success mx-1"
                        onclick="confirm('{{ __('¿Estás seguro de que deseas continuar?') }}') ? this.parentElement.submit() : ''">
                        {{ __('Confirmar') }}
                    </button>
                @else
                    <button type="button" class="btn btn-success mx-1"
                        data-dismiss="modal">{{ __('Aceptar') }}</button>
                @endif
            </div>
        </div>
    </div>
</div>
