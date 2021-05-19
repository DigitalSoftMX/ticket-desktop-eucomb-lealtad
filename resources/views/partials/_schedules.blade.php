@csrf
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            <a href="{{ route('schedules.index', $station) }}" title="Regresar a la lista" class="h4">
                <i class="tim-icons icon-minimal-left"></i>
            </a>
            {{ $message ?? __('Editar Turno') }}
        </h4>
        <p class="card-category"></p>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6">
                <label for="name">{{ __('Nombre del turno') }}</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="input-name"
                    aria-describedby="nameHelp" placeholder="Escribe el nombre del turno"
                    value="{{ old('name', $schedule->name ?? '') }}" aria-required="true" name="name">
                @if ($errors->has('name'))
                    <span id="name-error" class="error text-danger" for="input-name">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="form-group{{ $errors->has('start') ? ' has-danger' : '' }} col-sm-6">
                <label for="start">{{ __('Empieza') }}</label>
                <input type="time" list="liststart"
                    class="form-control{{ $errors->has('start') ? ' is-invalid' : '' }}" name="start" id="input-start"
                    value="{{ old('start', $schedule->start ?? '') }}" aria-required="true"
                    aria-describedby="startHelp" placeholder="Escribe la hora de inicio del turno" aria-required="true">
                @if ($errors->has('start'))
                    <span id="start-error" class="error text-danger" for="input-start">
                        {{ $errors->first('start') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('end') ? ' has-danger' : '' }} col-sm-6">
                <label for="end">{{ __('Termina') }}</label>
                <input type="time" list="listend" class="form-control{{ $errors->has('end') ? ' is-invalid' : '' }}"
                    name="end" id="input-end" value="{{ old('end', $schedule->end ?? '') }}" aria-required="true"
                    aria-describedby="second_endHelp" placeholder="Escribe la hora de finalización del turno"
                    aria-required="true">
                @if ($errors->has('end'))
                    <span id="end-error" class="error text-danger" for="input-end">{{ $errors->first('end') }}</span>
                @endif
            </div>
        </div>
        <div class="card-footer ml-auto mr-auto mt-5">
            <button type="submit" class="btn btn-primary">{{ $btnText ?? __('Actualizar') }}</button>
        </div>
    </div>
    <datalist id="liststart">
        <option value="00:00">
        <option value="01:00">
        <option value="02:00">
        <option value="03:00">
        <option value="04:00">
        <option value="05:00">
        <option value="06:00">
        <option value="07:00">
        <option value="08:00">
        <option value="09:00">
        <option value="10:00">
        <option value="11:00">
        <option value="12:00">
        <option value="13:00">
        <option value="14:00">
        <option value="15:00">
        <option value="16:00">
        <option value="17:00">
        <option value="18:00">
        <option value="19:00">
        <option value="20:00">
        <option value="21:00">
        <option value="22:00">
        <option value="23:00">
    </datalist>
    <datalist id="listend">
        <option value="00:59">
        <option value="01:59">
        <option value="02:59">
        <option value="03:59">
        <option value="04:59">
        <option value="05:59">
        <option value="06:59">
        <option value="07:59">
        <option value="08:59">
        <option value="09:59">
        <option value="10:59">
        <option value="11:59">
        <option value="12:59">
        <option value="13:59">
        <option value="14:59">
        <option value="15:59">
        <option value="16:59">
        <option value="17:59">
        <option value="18:59">
        <option value="19:59">
        <option value="20:59">
        <option value="21:59">
        <option value="22:59">
        <option value="23:59">
    </datalist>
</div>
