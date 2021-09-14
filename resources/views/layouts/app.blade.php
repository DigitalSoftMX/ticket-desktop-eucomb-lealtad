<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('EUCOMB', 'EUCOMB') }}</title>
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('white') }}/img/apple-icon.png">
        <link rel="icon" type="image/png" href="{{ asset('white') }}/img/favicon.png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('white') }}/css/nucleo-icons.css" rel="stylesheet" />
        <!-- CSS -->
        <link href="{{ asset('white') }}/css/white-dashboard.css?v=2.1.2" rel="stylesheet" />
        <link href="{{ asset('white') }}/css/theme.css" rel="stylesheet" />
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
            <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    </head>
    <body class="white-content {{ $class ?? '' }}  sidebar-mini">
        @auth()
            <div class="wrapper">
                    @include('layouts.navbars.sidebar')
                <div class="main-panel">
                    @include('layouts.navbars.navbar')

                    <div class="content">
                        @yield('content')
                    </div>

                    @include('layouts.footer')
                </div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            @include('layouts.navbars.navbar')
            <div class="wrapper wrapper-full-page">
                <div class="full-page {{ $contentClass ?? '' }}">
                    <div class=" container-fluid">
                        @yield('content')
                    </div>
                    @include('layouts.footer')
                </div>
            </div>
        @endauth
        <!--div class="fixed-plugin">
            <div class="dropdown show-dropdown">
                <a href="#" data-toggle="dropdown">
                <i class="fa fa-cog fa-2x"> </i>
                </a>
                <ul class="dropdown-menu">
                <li class="header-title"> Sidebar Background</li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors text-center">
                        <span class="badge filter badge-primary active" data-color="primary"></span>
                        <span class="badge filter badge-info" data-color="blue"></span>
                        <span class="badge filter badge-success" data-color="green"></span>
                    </div>
                    <div class="clearfix"></div>
                    </a>
                </li>
                <li class="button-container">
                    <a href="https://www.creative-tim.com/product/white-dashboard-laravel" target="_blank" class="btn btn-primary btn-block btn-round">Download Now</a>
                    <a href="https://white-dashboard-laravel.creative-tim.com/docs/getting-started/laravel-setup.html" target="_blank" class="btn btn-default btn-block btn-round">
                    Documentation
                    </a>
                </li>
                <li class="header-title">Thank you for 95 shares!</li>
                <li class="button-container text-center">
                    <button id="twitter" class="btn btn-round btn-info"><i class="fab fa-twitter"></i> &middot; 45</button>
                    <button id="facebook" class="btn btn-round btn-info"><i class="fab fa-facebook-f"></i> &middot; 50</button>
                    <br>
                    <br>
                    <a class="github-button" href="https://github.com/creativetimofficial/white-dashboard-laravel" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star ntkme/github-buttons on GitHub">Star</a>
                </li>
                </ul>
            </div>
        </div-->
        <script src="{{ asset('white') }}/js/core/jquery.min.js"></script>
        <script src="{{ asset('white') }}/js/core/popper.min.js"></script>
        <script src="{{ asset('white') }}/js/core/bootstrap.min.js"></script>
        <script src="{{ asset('white') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

        <!-- Plugin for the momentJs  -->
        <script src="{{ asset('white') }}/js/plugins/moment.min.js"></script>
        <!--  Plugin for Sweet Alert -->
        <script src="{{ asset('white') }}/js/plugins/sweetalert2.js"></script>

        <!-- Forms Validations Plugin -->
        <script src="{{ asset('white') }}/js/plugins/jquery.validate.min.js"></script>
        <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
        <script src="{{ asset('white') }}/js/plugins/jquery.bootstrap-wizard.js"></script>
        <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
        <script src="{{ asset('white') }}/js/plugins/bootstrap-selectpicker.js"></script>
        <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
        <script src="{{ asset('white') }}/js/plugins/bootstrap-datetimepicker.min.js"></script>
        <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
        <script src="{{ asset('white') }}/js/plugins/jquery.dataTables.min.js"></script>
        <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
        <script src="{{ asset('white') }}/js/plugins/bootstrap-tagsinput.js"></script>
        <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
        <script src="{{ asset('white') }}/js/plugins/jasny-bootstrap.min.js"></script>
        <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
        <script src="{{ asset('white') }}/js/plugins/fullcalendar.min.js"></script>
        <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
        <script src="{{ asset('white') }}/js/plugins/jquery-jvectormap.js"></script>
        <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
        <script src="{{ asset('white') }}/js/plugins/nouislider.min.js"></script>
        <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <!-- Library for adding dinamically elements -->
        <script src="{{ asset('white') }}/js/plugins/arrive.min.js"></script>

        <!--  Google Maps Plugin    -->
        <!-- Place this tag in your head or just before your close body tag. -->
        {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> --}}
        <!-- Chart JS -->
        <script src="{{ asset('white') }}/js/plugins/chartjs.min.js"></script>
        <!--script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.0"></script-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-doughnutlabel/2.0.3/chartjs-plugin-doughnutlabel.js" integrity="sha512-tqhJttGunGgQiVVp8pTNIwV39kpz8scVMRVpkBYyxrWFhsUQPP91a22+EYtxofO9eh1acFb+vIisxyPXg7Ll1g==" crossorigin="anonymous"></script>
        <!--script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels"></script-->
        <!--  Notifications Plugin    -->
        <script src="{{ asset('white') }}/js/plugins/bootstrap-notify.js"></script>

        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ asset('white') }}/js/white-dashboard.js?v=2.1.1" type="text/javascript"></script>

        
        <script src="{{ asset('white') }}/js/theme.js"></script>
        <script src="{{ asset('white') }}/js/styleChart/style.js"></script>
        <!--script src="{{ asset('white') }}/js/settings.js"></script-->
      
        <script src="{{ asset('js') }}/DateComponent.js"></script>
        <script src="{{ asset('js') }}/tabla_inicializador.js"></script>



        @stack('js')
        @stack('app')

        <script>
            // Ajax para consultar los movimientos
            $("#abonos").click(function() {
                $.ajax({
                    url: "{{ route('clients.search_client') }}",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'client_id' : $('#input-client_id').val(),
                        'inicial': $('#input-date-ini').val(),
                        'final': $('#input-date-end').val()
                    },
                    headers:{ 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                    },
                    success: function(response){
                        demo.showNotification('top','center', 'Consulta realizada correctamente.', 'tim-icons icon-bell-55');
                        destruir_table("datatable_1");
                        destruir_table("datatable_2");
                        destruir_table("datatable_3");
                        destruir_table("datatable_4");


                        $('#datatable_1').find('tbody').empty();
                        $('#datatable_2').find('tbody').empty();
                        $('#datatable_3').find('tbody').empty();

                        for(i=0; i<response.payments.length; i++){
                            $("#datatable_1").find('tbody').append(
                                '<tr><td>'+response.payments[i][0]+'</td><td>'+response.payments[i][1]+'</td><td>'+response.payments[i][2]+'</td><td>'+response.payments[i][3]+'</td><td>'+response.payments[i][4]+'</td><td>'+response.payments[i][5]+'</td></tr>'
                            );
                        }
                        for(i=0; i<response.transfers.length; i++){
                            $("#datatable_2").find('tbody').append(
                                '<tr><td>'+response.transfers[i][0]+'</td><td>'+response.transfers[i][1]+'</td><td>'+response.transfers[i][2]+'</td><td>'+response.transfers[i][3]+'</td><td>'+response.transfers[i][4]+'</td>  </tr>'
                            );
                        }
                        for(i=0; i<response.transfers_2.length; i++){
                            $("#datatable_4").find('tbody').append(
                                '<tr><td>'+response.transfers_2[i][0]+'</td><td>'+response.transfers_2[i][1]+'</td><td>'+response.transfers_2[i][2]+'</td><td>'+response.transfers_2[i][3]+'</td><td>'+response.transfers_2[i][4]+'</td>  </tr>'
                            );
                        }
                        for(i=0; i<response.deposits.length; i++){
                            $("#datatable_3").find('tbody').append(
                                '<tr><td>'+response.deposits[i][0]+'</td><td>'+response.deposits[i][1]+'</td><td>'+response.deposits[i][3]+'</td><td>'+response.deposits[i][4]+'</td><td>'+response.deposits[i][5]+'</td></tr>'
                            );
                        }
                        iniciar_date('datatable_1');
                        iniciar_date('datatable_2');
                        iniciar_date('datatable_3');
                        iniciar_date('datatable_4');
                    },
                    error: function(error){
                        demo.showNotification('top','center', error, 'tim-icons icon-bell-55');
                    }
                });
            });
            // Ajax para los canjes
            $("#exchanges").click(function() {
                $.ajax({
                    url: "{{ route('getexchanges') }}",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'client_id' : $('#input-client_id').val(),
                        'inicial': $('#input-date-ini').val(),
                        'final': $('#input-date-end').val()
                    },
                    headers:{ 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                    },
                    success: function(response){
                        demo.showNotification('top','center', 'Consulta realizada correctamente.', 'tim-icons icon-bell-55');
                        destruir_table("process");
                        destruir_table("history");
                        $('#process').find('tbody').empty();
                        $('#history').find('tbody').empty();
                        for(i=0;i<response.process.length;i++){
                            $("#process").find('tbody').append(
                                '<tr><td>'+response.process[i].exchange+'</td><td>'+response.process[i].station+'</td><td>'+response.process[i].status+'</td><td>'+response.process[i].date+'</td></tr>'
                            );
                        }
                        for(i=0;i<response.history.length;i++){
                            $("#history").find('tbody').append(
                                '<tr><td>'+response.history[i].exchange+'</td><td>'+response.history[i].station+'</td><td>'+response.history[i].status+'</td><td>'+response.history[i].admin+'</td><td>'+response.history[i].date+'</td></tr>'
                            );
                        }
                        iniciar_date('process');
                        iniciar_date('history');
                    },
                    error: function(error){
                        demo.showNotification('top','center', error, 'tim-icons icon-bell-55');
                    }
                });
            });
            $("#btnHistory").click(function(){
                $.ajax({
                    url: "{{ route('get.history') }}",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'start': $('#input-date-ini').val(),
                        'end': $('#input-date-end').val(),
                        'folio': $('#folio').val(),
                        'membresia': $('#membresia').val(),
                    },
                    headers:{ 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                    },
                    success: function(response){
                        demo.showNotification('top','center', 'Consulta realizada correctamente.', 'tim-icons icon-bell-55');
                        console.log(response);
                        destruir_table("datatable_1");
                        destruir_table("datatable_2");
                        $('#datatable_1').find('tbody').empty();
                        $('#datatable_2').find('tbody').empty();
                        for(i=0;i<response.points.length;i++){
                            $("#datatable_1").find('tbody').append(
                                '<tr><td>'+response.points[i].membership+'</td><td>'+response.points[i].sale+'</td><td>'+response.points[i].points+'</td><td>'+response.points[i].liters+'</td><td>'+response.points[i].gasoline+'</td><td>'+response.points[i].station+'</td><td>'+response.points[i].date+'</td></tr>'
                            );
                        }
                        for(i=0;i<response.exchanges.length;i++){
                            
                            $("#datatable_2").find('tbody').append(
                                '<tr><td>'+response.exchanges[i].folio+'</td><td>'+response.exchanges[i].station+'</td><td>'+response.exchanges[i].membership+'</td><td>'+response.exchanges[i].points+'</td><td>'+response.exchanges[i].admin+'</td><td>'+response.exchanges[i].date+'</td></tr>'
                            );
                        }
                        iniciar_date('datatable_1');
                        iniciar_date('datatable_2');
                    },
                    error: function(error){
                        demo.showNotification('top','center', error, 'tim-icons icon-bell-55');
                    }
                });
            });

            function desabilitarBoton(id){
                document.getElementById(id).disabled = true;
                document.getElementById(id).innerHTML="Enviando...";
                setTimeout(function() {
                    document.getElementById(id).disabled = false;
                    document.getElementById(id).innerHTML = "Enviar";
                }, 3000);
                
            }

            $(document).ready(function() {

                $("#botonFormEnvioForm").closest('form').on('submit', function(e) {
                    e.preventDefault();
                    $('#botonFormEnvio').attr('disabled', true);
                    this.submit(); // ahora hace el submit de tu formulario.
                });
                
                iniciar_date('usuarios');
                iniciar_date('autorizados');
                iniciar_date('denegados');
                iniciar_date('datatable_1');
                iniciar_date('datatable_2');
                iniciar_date('datatable_3');

                @if(session('status'))
                    demo.showNotification('top','center', '{{ session('status') }}', 'tim-icons icon-bell-55');
                @endif
                $().ready(function() {
                    $sidebar = $('.sidebar');
                    $navbar = $('.navbar');
                    $main_panel = $('.main-panel');

                    $full_page = $('.full-page');

                    $sidebar_responsive = $('body > .navbar-collapse');
                    sidebar_mini_active = true;
                    white_color = false;

                    window_width = $(window).width();

                    fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                    $('.fixed-plugin a').click(function(event) {
                        if ($(this).hasClass('switch-trigger')) {
                            if (event.stopPropagation) {
                                event.stopPropagation();
                            } else if (window.event) {
                                window.event.cancelBubble = true;
                            }
                        }
                    });

                    $('.fixed-plugin .background-color span').click(function() {
                        $(this).siblings().removeClass('active');
                        $(this).addClass('active');

                        var new_color = $(this).data('color');

                        if ($sidebar.length != 0) {
                            $sidebar.attr('data', new_color);
                        }

                        if ($main_panel.length != 0) {
                            $main_panel.attr('data', new_color);
                        }

                        if ($full_page.length != 0) {
                            $full_page.attr('filter-color', new_color);
                        }

                        if ($sidebar_responsive.length != 0) {
                            $sidebar_responsive.attr('data', new_color);
                        }
                    });

                    $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
                        var $btn = $(this);

                        if (sidebar_mini_active == true) {
                            $('body').removeClass('sidebar-mini');
                            sidebar_mini_active = false;
                            whiteDashboard.showSidebarMessage('Sidebar mini deactivated...');
                        } else {
                            $('body').addClass('sidebar-mini');
                            sidebar_mini_active = true;
                            whiteDashboard.showSidebarMessage('Sidebar mini activated...');
                        }

                        // we simulate the window Resize so the charts will get updated in realtime.
                        var simulateWindowResize = setInterval(function() {
                            window.dispatchEvent(new Event('resize'));
                        }, 180);

                        // we stop the simulation of Window Resize after the animations are completed
                        setTimeout(function() {
                            clearInterval(simulateWindowResize);
                        }, 1000);
                    });

                    $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
                            var $btn = $(this);

                            if (white_color == true) {
                                $('body').addClass('change-background');
                                setTimeout(function() {
                                    $('body').removeClass('change-background');
                                    $('body').removeClass('white-content');
                                }, 900);
                                white_color = false;
                            } else {
                                $('body').addClass('change-background');
                                setTimeout(function() {
                                    $('body').removeClass('change-background');
                                    $('body').addClass('white-content');
                                }, 900);

                                white_color = true;
                            }
                    });

                    $('.light-badge').click(function() {
                        $('body').addClass('white-content');
                    });

                    $('.dark-badge').click(function() {
                        $('body').removeClass('white-content');
                    });
                });
            });
        </script>
        
    </body>
</html>
