@csrf
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            @if ($station->id != null)
                <a href="{{ route('dispatcher.index', $station) }}" title="Regresar a la lista" class="h4">
                    <i class="tim-icons icon-minimal-left"></i>
                </a>
            @else
                <a href="{{ route('dispatchers.index') }}" title="Regresar a la lista" class="h4">
                    <i class="tim-icons icon-minimal-left"></i>
                </a>
            @endif
            {{ $message ?? __('Editar despachador') }}
        </h4>
        <p class="card-category"></p>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6">
                <label for="name">{{ __('Nombre') }}</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="input-name"
                    aria-describedby="nameHelp" placeholder="Escribe un nombre"
                    value="{{ old('name', $dispatcher->user->name ?? '') }}" aria-required="true" name="name">
                @if ($errors->has('name'))
                    <span id="name-error" class="error text-danger" for="input-name">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('first_surname') ? ' has-danger' : '' }} col-sm-6">
                <label for="first_surname">{{ __('Apellido Paterno') }}</label>
                <input type="text" class="form-control{{ $errors->has('first_surname') ? ' is-invalid' : '' }}"
                    name="first_surname" id="input-first_surname"
                    value="{{ old('first_surname', $dispatcher->user->first_surname ?? '') }}" aria-required="true"
                    aria-describedby="first_surnameHelp" placeholder="Escribe el primer apellido" aria-required="true">
                @if ($errors->has('first_surname'))
                    <span id="first_surname-error" class="error text-danger" for="input-first_surname">
                        {{ $errors->first('first_surname') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="form-group{{ $errors->has('second_surname') ? ' has-danger' : '' }} col-sm-6">
                <label for="first_surname">{{ __('Apellido Materno') }}</label>
                <input type="text" class="form-control{{ $errors->has('second_surname') ? ' is-invalid' : '' }}"
                    name="second_surname" id="input-second_surname"
                    value="{{ old('second_surname', $dispatcher->user->second_surname ?? '') }}" aria-required="true"
                    aria-describedby="second_surnameHelp" placeholder="Escribe el segundo apellido"
                    aria-required="true">
                @if ($errors->has('second_surname'))
                    <span id="second_surname-error" class="error text-danger"
                        for="input-second_surname">{{ $errors->first('second_surname') }}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }} col-sm-6">
                <label for="phone">{{ __('Teléfono') }}</label>
                <input type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                    id="input-phone" aria-describedby="phoneHelp" placeholder="Escribe el teléfono"
                    value="{{ old('phone', $dispatcher->user->phone ?? '') }}" aria-required="true" name="phone">
                @if ($errors->has('phone'))
                    <span id="phone-error" class="error text-danger" for="input-phone">
                        {{ $errors->first('phone') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }} col-sm-6">
                <label for="address">{{ __('Dirección') }}</label>
                <input type="text" class="form-control" name="address" id="input-address"
                    value="{{ old('address', $dispatcher->user->address ?? '') }}" aria-required="true"
                    aria-describedby="addressHelp" placeholder="Escribe la dirección" aria-required="true">
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} col-sm-6">
                <label for="email">{{ __('Email') }}</label>
                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                    id="input-email" type="email" value="{{ old('email', $dispatcher->user->email ?? '') }}"
                    aria-required="true" aria-describedby="emailHelp" placeholder="Escribe el email del usuario"
                    aria-required="true">
                @if ($errors->has('email'))
                    <span id="email-error" class="error text-danger" for="input-email">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }} col-sm-6">
                <label for="password">{{ __('Contraseña') }}</label>
                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                    id="input-password" type="password" aria-describedby="passwordHelp"
                    placeholder="Escribe la contraseña">
                @if ($errors->has('password'))
                    <span id="password-error" class="error text-danger" for="input-password">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>
            <div class="form-group col-sm-6">
                <label for="password_confirmation">{{ __('Confirmar contraseña') }}</label>
                <input type="password" class="form-control" id="input-password_confirmation"
                    aria-describedby="passwordHelp" placeholder="Confirmar contraseña" name="password_confirmation">
            </div>
        </div>

        <div class="row mt-3">
            <div class="form-group{{ $errors->has('sex') ? ' has-danger' : '' }} col-sm-6">
                <label for="input-sex">Genero</label>
                <select id="input-sex" name="sex"
                    class="selectpicker show-menu-arrow {{ $errors->has('sex') ? ' has-danger' : '' }}"
                    data-style="btn-primary" data-width="100%" data-live-search="true">
                    <option value="">{{ __('Elija una opción') }}</option>
                    <option value="M" @if ($dispatcher->user->sex ?? '' == 'M') selected @endif>Femenino</option>
                    <option value="H" @if ($dispatcher->user->sex ?? '' == 'H') selected @endif>Masculino</option>
                </select>
                @if ($errors->has('sex'))
                    <span id="sex-error" class="error text-danger" for="input-sex">
                        {{ $errors->first('sex') }}
                    </span>
                @endif
            </div>
            @if ($station->id == null)
                <div class="form-group{{ $errors->has('station_id') ? ' has-danger' : '' }} col-sm-6">
                    <label for="input-station">{{ __('Estación') }}</label>
                    <select id="input-station"
                        class="selectpicker show-menu-arrow {{ $errors->has('station_id') ? ' has-danger' : '' }}"
                        data-style="btn-primary" data-width="100%" data-live-search="true" name="station_id">
                        <option data-tokens="" value="">{{ __('Elija una opción') }}</option>
                        @foreach ($stations as $s)
                            <option data-tokens="{{ $s->name }}" value="{{ $s->id }}" @if (($st = $dispatcher->station_id ?? '') == $s->id) selected @endif>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('station_id'))
                        <span id="station_id-error" class="error text-danger" for="input-station_id">
                            {{ $errors->first('station_id') }}
                        </span>
                    @endif
                </div>
            @endif
        </div>

        <div class="row mt-3">
            <div class="form-group{{ $errors->has('schedule_id') ? ' has-danger' : '' }} col-sm-6">
                <label for="input-schedule">{{ __('Horario') }}</label>
                <select id="input-schedule" name="schedule_id"
                    class="selectpicker show-menu-arrow {{ $errors->has('schedule_id') ? ' has-danger' : '' }}"
                    data-style="btn-primary" data-width="100%" data-live-search="true">
                    <option data-tokens="" value="">{{ __('Elija una opción') }}</option>
                    @if ($station->id != null)
                        @foreach ($station->schedules as $schedule)
                            <option value="{{ $schedule->id }}" @if (($sch = $dispatcher->schedule_id ?? '') == $schedule->id) selected @endif>
                                {{ $schedule->name }} - De: {{ $schedule->start }}
                                hrs A: {{ $schedule->end }} hrs
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group{{ $errors->has('island_id') ? ' has-danger' : '' }} col-sm-6">
                <label for="input-island">{{ __('Isla y bomba') }}</label>
                <select id="input-island" name="island_id"
                    class="selectpicker show-menu-arrow {{ $errors->has('island_id') ? ' has-danger' : '' }}"
                    data-style="btn-primary" data-width="100%" data-live-search="true">
                    <option data-tokens="" value="">{{ __('Elija una opción') }}</option>
                    @if ($station->id != null)
                        @foreach ($station->islands as $island)
                            <option value="{{ $island->id }}"> Isla {{ $island->island }} Bomba
                                {{ $island->bomb }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <input type="hidden" id="active" value="1" name="active">
        @if ($station->id != null)
            <input type="hidden" name="station_id" id="station_id" value="{{ $station->id }}">
        @endif
        <div class="card-footer ml-auto mr-auto mt-5">
            <button type="submit" class="btn btn-primary">{{ $btnText ?? __('Actualizar') }}</button>
        </div>
    </div>
</div>
@push('app')
    <script>
        let station = "{{ $dispatcher->station_id ?? '' }}";
        if (station != '') {
            schedules(station);
        }
        $("#input-station").change(function() {
            station = document.getElementById('input-station').value;
            schedules(station);
        });

        async function schedules(station) {
            try {
                const resp = await fetch("{{ route('admins.schedules') }}", {
                    method: "post",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": $('input[name="_token"]').val()
                    },
                    body: JSON.stringify({
                        station: station
                    })
                });
                const data = await resp.json();
                console.log(data);
                $('#input-schedule').children('option:not(:first)').remove();
                $('#input-island').children('option:not(:first)').remove();
                data.schedules.forEach(schedule => {
                    $('#input-schedule').append( /* html */ `
                        <option value="${schedule.id}" ${(sch="{{ $dispatcher->schedule_id ?? '' }}")==schedule.id?'selected':''}>
                            ${schedule.name} De: ${schedule.start} hrs A: ${schedule.end} hrs
                        </option>
                    `);
                });
                data.islands.forEach(island => {
                    $('#input-island').append( /* html */ `
                    <option value="${island.id}" ${(isl="{{ $dispatcher->island_id ?? '' }}")==island.id?'selected':''}>
                        Isla ${island.island} - Bomba ${island.bomb}
                    </option>
                    `);
                });
                $('#input-schedule').selectpicker('refresh');
                $('#input-island').selectpicker('refresh');
            } catch (error) {
                console.log(error);
            }
        }
    </script>
@endpush
