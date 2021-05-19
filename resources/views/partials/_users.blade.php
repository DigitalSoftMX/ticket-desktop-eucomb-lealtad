<tr>
    @if ($user->roles[0]->id == 4)
        <td>{{ $user->dispatcher->dispatcher_id }}</td>
    @endif
    <td>{{ $user->name }}</td>
    <td>{{ $user->first_surname }} {{ $user->second_surname }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->phone }}</td>
    <td>
        @foreach ($user->roles as $role)
            {{ $rol = $role->name }},
        @endforeach
    </td>
    @if ($user->roles[0]->id == 4)
        <td>{{ $user->dispatcher->station->name }}</td>
        <td>De: {{ $user->dispatcher->schedule->start }} hrs A: {{ $user->dispatcher->schedule->end }} hrs</td>
    @else
        @if ($user->admin != null)
            <td>{{ $user->admin->station->name }}</td>
            <td>De: {{ $user->admin->schedule->start }} hrs A: {{ $user->admin->schedule->end }} hrs</td>
        @else
            <td>{{ __('-') }}</td>
            <td>{{ __('-') }}</td>
        @endif
    @endif
    <td>{{ $user->created_at->format('d/m/Y') }}</td>
    <td class="td-actions text-right">
        @if ($user->roles[0]->id != auth()->user()->roles[0]->id)
            <a rel="tooltip" class="btn btn-success btn-link" @if ($station->id != null)
                href="{{ route("$route.edit", [$station, $user]) }}"
            @else
                href="{{ route("$route.edit", $user) }}"
        @endif
        data-original-title="" title="">
        <i class="tim-icons icon-pencil"></i>
        <div class="ripple-container"></div>
        </a>
        @if ($rol != 'usuario')
            <form @if ($station->id != null)
                action="{{ route("$route.destroy", [$station, $user]) }}"
            @else
                action="{{ route("$route.destroy", $user) }}"
        @endif
        method="post">
        @csrf
        @method('delete')
        <button type="button" class="btn btn-danger btn-link" data-original-title="" title=""
            onclick="confirm('{{ __('¿Estás seguro de que deseas eliminar este usuario?') }}') ? this.parentElement.submit() : ''">
            <i class="tim-icons icon-trash-simple"></i>
            <div class="ripple-container"></div>
        </button>
        </form>
        @endif
        @endif
    </td>
</tr>
