<div class="sidebar" data="green">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __(auth()->user()->name) }}</a>
            <a href="#" class="simple-text logo-normal">{{ auth()->user()->name }}
                {{ auth()->user()->first_surname }}</a>
        </div>
        <ul class="nav mb-5">
            @for ($i = 0; $i < count($menus); $i++)
                @foreach ($menus[$i] as $menu)
                    @if ($menu->desplegable == 0)
                        <li class="nav-item{{ $pageSlug == $menu->name_modulo ? ' active' : '' }}">
                            <a class="nav-link" href="{{ url($menu->ruta) }}">
                                @if ($menu->id_role == 1)
                                    <i class="material-icons-outlined">{{ $menu->icono }}</i>
                                @else
                                    <i class="tim-icons {{ $menu->icono }}"></i>
                                @endif
                                <p>{{ __($menu->name_modulo) }}</p>
                            </a>
                        </li>
                    @endif
                @endforeach
            @endfor
        </ul>
    </div>
</div>
