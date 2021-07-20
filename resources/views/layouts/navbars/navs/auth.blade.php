<nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-toggle d-inline">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand d-none d-lg-block d-xl-block"
                href="{{ route('home') }}">{{ $titlePage ?? __($titlePage) }}</a>
            <!--div class="row"-->
            <div class="col-sm-6">
                <a class="navbar-brand">{{ __('Mi código:') }} &nbsp;
                    <strong>{{ auth()->user()->username }}</strong>
                </a>
            </div>
            @if ($titlePage == 'dashboard')
                <div class="col-sm-6 d-none d-lg-block d-xl-block">
                    <div class="nav-tabs-navigation alinearTab">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav" data-tabs="tabs">
                                <!--li class="nav-item">
                                        <a class="nav-link" href="#home" data-toggle="tab">General</a>
                                    </li-->
                                <li class="nav-item">
                                    <a class="nav-link active" href="#updates" data-toggle="tab">Lealtad</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#history" data-toggle="tab">Prepago</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            <!--/div-->
            @if ($titlePage != 'dashboard' && $titlePage != 'Estaciones')
                @isset($station)
                    <div class="nav-tabs-navigation alinearTab d-none d-lg-block d-xl-block">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav" data-tabs="tabs">
                                <!--li class="nav-item">
                                                    <a class="nav-link" href="#home" data-toggle="tab">General</a>
                                                </li-->
                                <li class="nav-item">
                                    <a class="nav-link active" href="#updates" data-toggle="tab">Lealtad</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#history" data-toggle="tab">Prepago</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endisset
            @endif



        </div>
        <div class="row mt-3">
            <div class="col-1">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                </button>
            </div>
            <div class="col-6 pl-0 navbar-toggler">
                @if ($titlePage == 'dashboard')

                    <div class="nav-tabs-navigation alinearTab">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav" data-tabs="tabs">
                                <!--li class="nav-item">
                                    <a class="nav-link" href="#home" data-toggle="tab">General</a>
                                </li-->
                                <li class="nav-item">
                                    <a class="nav-link active" href="#updates" data-toggle="tab">Lealtad</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#history" data-toggle="tab">Prepago</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                @endif
            </div>
        </div>




        <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">
                <li class="search-bar input-group">
                    <button class="btn btn-link" id="search-button" data-toggle="modal" data-target="#searchModal"><i
                            class="tim-icons icon-zoom-split"></i>
                        <span class="d-lg-none d-md-block">{{ __('Buscar') }}</span>
                    </button>
                </li>
                <!--li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <div class="notification d-none d-lg-block d-xl-block"></div>
                        <i class="tim-icons icon-sound-wave"></i>
                        <p class="d-lg-none"> {{ __('Notificaciones') }} </p>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-navbar">
                        <li class="nav-link">
                            <a href="#" class="nav-item dropdown-item">{{ __('Notificaciones') }}</a>
                        </li>
                    </ul>
                </li-->

                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <div class="photo">
                            <img src="{{ asset('white') }}/img/anime6.png" alt="{{ __('Foto de Perfil') }}">
                        </div>
                        <b class="caret d-none d-lg-block d-xl-block"></b>
                        <p class="d-lg-none">{{ __('Cerrar sesión') }}</p>
                    </a>
                    <ul class="dropdown-menu dropdown-navbar">
                        <li class="nav-link">
                            <a href="{{ route('profile.edit') }}"
                                class="nav-item dropdown-item">{{ __('Perfil') }}</a>
                        </li>
                        <li class="nav-link">
                            <a href="#" class="nav-item dropdown-item">{{ __('Configuraciones') }}</a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="nav-link">
                            <a href="{{ route('logout') }}" class="nav-item dropdown-item"
                                onclick="event.preventDefault();  document.getElementById('logout-form').submit();">{{ __('Cerrar sesión') }}</a>
                        </li>

                        <!--li class="nav-link">
                            <a href="{{ route('profile.edit') }}" class="nav-item dropdown-item">{{ __('Perfil') }}</a>
                        </li-->


                    </ul>

                </li>
                <li class="separator d-lg-none"></li>

            </ul>
        </div>
    </div>
</nav>
<div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="{{ __('Buscar') }}">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Cerrar') }}">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
            </div>
        </div>
    </div>
</div>
