<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>{{ config('app.name', 'Carto-Web') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link
        rel="icon"
        href="assets/img/kaiadmin/favicon.ico"
        type="image/x-icon"
        />
        <!-- Fonts and icons -->
        <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
        <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],
            urls: ["{{ asset('assets/css/fonts.min.css') }}"],
            },
            active: function () {
            sessionStorage.fonts = true;
            (window).on('load', function (){(".se-pre-con").fadeOut("slow");
                });
            },
        });
        </script>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />
        
        <link rel="stylesheet" href="{{ asset('assets/css/jquery.rtnotify.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/cartoweb.css') }}" /> 
        <!-- Intégration de Leaflet -->
        <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}">

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
        body { margin: 0; padding: 0; }
        #map { height: 100vh; width: 100%; }
        .leaflet-control-layers-overlays { font-size: 14px; }
        .structure-icon { background: transparent !important; border: none !important; }
        .filter-control {
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        .filter-control select { width: 100%; padding: 5px; margin-top: 5px; }
    </style>
    </head>
    <body>
        <div class="se-pre-con"></div>  
        <div id="envoi"></div>
        <div class="wrapper">
            <div class="sidebar" data-background-color="">
                <div class="sidebar-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                      <a href="/" class="logo">
                        {{-- <img
                          src="{{ asset('assets/img/kaiadmin/logo_light.svg')}}"
                          alt="navbar brand"
                          class="navbar-brand"
                          height="20"
                        /> --}}
                      </a>
                      <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                          <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                          <i class="gg-menu-left"></i>
                        </button>
                      </div>
                      <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                      </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <div class="sidebar-wrapper scrollbar scrollbar-inner">
                    <div class="sidebar-content">
                        <ul class="nav nav-secondary">
                            @foreach (session('menus') as $key=>$item)
                                <li class="nav-item active" id="colapse-{{ $item[0]->menu_id }}" onclick="Collapser(this.id);">
                                <a
                                    data-bs-toggle="collapse"
                                    href="#sd{{ $item[0]->menu_id }}" id="a{{ $item[0]->menu_id }}"
                                    class="collapsed"
                                    aria-expanded="false"
                                >
                                    <i class="{{$item[0]->icon}}"></i>
                                    <p>{{$item[0]->nomMenu}}</p>
                                    @if (!empty($item[1]) )<span class="caret"></span>@endif
                                </a>
                                <div class="collapse" id="sd{{ $item[0]->menu_id }}">
                                    <ul class="nav nav-collapse">
                                        @if (!empty($item[1]) )
                                            @foreach ($item[1] as $skey => $sousMenu)
                                                @php $test= "route" ; @endphp
                                                <li>
                                                    <a href="{{ $test($sousMenu[0]->lien)  }}/{{$item[0]->menu_id}}/{{$sousMenu[0]->menu_id}}" id="sousMenu{{$sousMenu[0]->menu_id}}">
                                                    <span class="sub-item">{{$sousMenu[0]->nomMenu}}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                </li>
                             
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- end sidbar-wrapper-->
            </div>
            <!-- end sidbar-->
            <div class="main-panel">
                <div class="main-header">
                  <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                      <a href="index.html" class="logo">
                        <img
                          src="assets/img/kaiadmin/logo_light.svg"
                          alt="navbar brand"
                          class="navbar-brand"
                          height="20"
                        />
                      </a>
                      <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                          <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                          <i class="gg-menu-left"></i>
                        </button>
                      </div>
                      <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                      </button>
                    </div>
                    <!-- End Logo Header -->
                  </div>
                  <!-- Navbar Header -->
                  <nav
                    class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
                  >
                    <div class="container-fluid">
                      <nav
                        class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
                      >
                        {{-- <div class="input-group">
                          <div class="input-group-prepend">
                            <button type="submit" class="btn btn-search pe-1">
                              <i class="fa fa-search search-icon"></i>
                            </button>
                          </div>
                          <input
                            type="text"
                            placeholder="Search ..."
                            class="form-control"
                          />
                        </div> --}}
                      </nav>
        
                      <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                        <li
                          class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                        >
                          <a
                            class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown"
                            href="#"
                            role="button"
                            aria-expanded="false"
                            aria-haspopup="true"
                          >
                            <i class="fa fa-search"></i>
                          </a>
                          <ul class="dropdown-menu dropdown-search animated fadeIn">
                            {{-- <form class="navbar-left navbar-form nav-search">
                              <div class="input-group">
                                <input
                                  type="text"
                                  placeholder="Search ..."
                                  class="form-control"
                                />
                              </div>
                            </form> --}}
                          </ul>
                        </li>
                        
                        <li class="nav-item topbar-icon dropdown hidden-caret">
                          <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="notifDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >
                            <i class="fa fa-bell"></i>
                            <span class="notification">4</span>
                          </a>
                          <ul
                            class="dropdown-menu notif-box animated fadeIn"
                            aria-labelledby="notifDropdown"
                          >
                            <li>
                              <div class="dropdown-title">
                                You have 4 new notification
                              </div>
                            </li>
                            <li>
                              <div class="notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                  <a href="#">
                                    <div class="notif-icon notif-primary">
                                      <i class="fa fa-user-plus"></i>
                                    </div>
                                    <div class="notif-content">
                                      <span class="block"> New user registered </span>
                                      <span class="time">5 minutes ago</span>
                                    </div>
                                  </a>
                                  <a href="#">
                                    <div class="notif-icon notif-success">
                                      <i class="fa fa-comment"></i>
                                    </div>
                                    <div class="notif-content">
                                      <span class="block">
                                        Rahmad commented on Admin
                                      </span>
                                      <span class="time">12 minutes ago</span>
                                    </div>
                                  </a>
                                  <a href="#">
                                    <div class="notif-img">
                                      <img
                                        src="assets/img/profile2.jpg"
                                        alt="Img Profile"
                                      />
                                    </div>
                                    <div class="notif-content">
                                      <span class="block">
                                        Reza send messages to you
                                      </span>
                                      <span class="time">12 minutes ago</span>
                                    </div>
                                  </a>
                                  <a href="#">
                                    <div class="notif-icon notif-danger">
                                      <i class="fa fa-heart"></i>
                                    </div>
                                    <div class="notif-content">
                                      <span class="block"> Farrah liked Admin </span>
                                      <span class="time">17 minutes ago</span>
                                    </div>
                                  </a>
                                </div>
                              </div>
                            </li>
                            <li>
                              <a class="see-all" href="javascript:void(0);"
                                >See all notifications<i class="fa fa-angle-right"></i>
                              </a>
                            </li>
                          </ul>
                        </li>
                        <li class="nav-item topbar-user dropdown hidden-caret">
                          <a
                            class="dropdown-toggle profile-pic"
                            data-bs-toggle="dropdown"
                            href="#"
                            aria-expanded="false"
                          >
                            <div class="avatar-sm">
                              <img
                                src="{{ asset('images/avatar.png') }}"
                                alt="..."
                                class="avatar-img rounded-circle"
                              />
                            </div>
                            <span class="profile-username">
                              {{-- <span class="op-7">Hi,</span> --}}
                              <span class="fw-bold">{{ Auth()->user()->identifiant}}</span>
                            </span>
                          </a>
                          <ul class="dropdown-menu dropdown-user animated fadeIn">
                            <div class="dropdown-user-scroll scrollbar-outer">
                              <li>
                                <div class="user-box">
                                  <div class="avatar-lg">
                                    <img
                                      src="assets/img/profile.jpg"
                                      alt="image profile"
                                      class="avatar-img rounded"
                                    />
                                  </div>
                                  <div class="u-text">
                                    <h4>{{Auth()->user()->prenom.' '.Auth()->user()->nom}}</h4>
                                    <p class="text-muted">{{Auth()->user()->email}}</p>
                                    <a
                                      href="profile.html"
                                      class="btn btn-xs btn-secondary btn-sm"
                                      >Mon profil</a
                                    >
                                  </div>
                                </div>
                              </li>
                              <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">{{ Auth()->user()->prenom }}</a>
                                
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">{{ Auth()->user()->nom}}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" title="Se déconnecter">
                                        <i class="nav-icon fa-solid fa-power-off"></i>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                    </form>

                                </a>
                              </li>
                            </div>
                          </ul>
                        </li>
                      </ul>
                    </div>
                  </nav>
                  <!-- End Navbar -->
                </div>
        
                <div class="container">
                  <div class="page-inner">
                    {{-- <div class="page-header">
                      <h4 class="page-title">Dashboard</h4>
                      <ul class="breadcrumbs">
                        <li class="nav-home">
                          <a href="#">
                            <i class="icon-home"></i>
                          </a>
                        </li>
                        <li class="separator">
                          <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                          <a href="#">Pages</a>
                        </li>
                        <li class="separator">
                          <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                          <a href="#">Starter Page</a>
                        </li>
                      </ul>
                    </div> --}}
                    <div class="page-category">
                      @if (session('success'))
                          <div class="alert alert-success" id="notif">
                              <button class="close" type="button" onclick="$('#notif').hide();" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                              </button>
                              {{session('success')}}
                          </div>
                      @endif
                      @if (session('error'))
                          <div class="alert alert-danger" id="notifError">
                              <button class="close" type="button" onclick="$('#notifError').hide();" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                              </button>
                              {{session('error')}}
                          </div>
                      @endif
                      <br>
                        @yield('content')
                    </div>
                  </div>
                </div>
        
                <footer class="footer">
                  <div class="container-fluid d-flex justify-content-between">
                    <nav class="pull-left">
                      <ul class="nav">
                        <li class="nav-item">
                          <a class="nav-link" href="http://www.themekita.com">
                            ThemeKita
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#"> Help </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#"> Licenses </a>
                        </li>
                      </ul>
                    </nav>
                    <div class="copyright">
                      2025, made with <i class="fa fa-heart heart text-danger"></i> by
                      <a href="#">DSI</a>
                    </div>
                    <div>
                      Distributed by
                      <a target="_blank" href="#">DSI</a>.
                    </div>
                  </div>
                </footer>
              </div>
        </div>
        <!-- end wrapper-->
        <!-- Integration du Js de Mapleaflet-->
        <script src="{{ asset('js/leaflet.js') }}"></script>
        <!--   Core JS Files   -->
        <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js')}}"></script>
        <script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
        <script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>
        <script src="{{ asset('assets/js/inputmask/jquery.inputmask.min.js') }}"></script>
        <!-- jQuery Scrollbar -->
        <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

        <!-- Chart JS -->
        <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js')}}"></script>

        <!-- jQuery Sparkline -->
        <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

        <!-- Chart Circle -->
        <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js')}}"></script>

        <!-- Datatables -->
        <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>

        <!-- Bootstrap Notify -->
        <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

        <!-- jQuery Vector Maps -->
        <script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
        <script src="{{ asset('assets/js/plugin/jsvectormap/world.js')}}"></script>

        <!-- Google Maps Plugin -->
        <script src="{{ asset('assets/js/plugin/gmaps/gmaps.js')}}"></script>

        <!-- Sweet Alert -->
        <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

        <!-- Kaiadmin JS -->
        <script src="{{ asset('assets/js/kaiadmin.min.js')}}"></script>
        <script src="{{ asset('assets/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/js/fr.js') }}"></script>
        <script src="{{ asset('assets/js/table.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.rtnotify.js') }}"></script>
        <script src="{{ asset('assets/js/scriptAjax.js')}}"></script>
        <script src="{{ asset('assets/js/scriptSup.js') }}"></script>
        <script src="{{ asset('assets/js/webcarto.js') }}"></script>
        <script>(window).on('load', function () {
            $(".se-pre-con").fadeOut("slow");
        });
    </script>
    
    </body>

    <script>
        // Exemple de JavaScript de démarrage pour désactiver les soumissions de formulaire s'il y a des champs invalides
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Récupérer tous les formulaires auxquels nous voulons appliquer des styles de validation Bootstrap personnalisés
                var forms = document.getElementsByClassName('needs-validation');
                // Faites une boucle sur eux et empêchez la soumission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    <script>
        $('.calendrier').datepicker({
             dateFormat:'dd-mm-yy',
             closeText:'Fermer',
             prevText:'Precedant',
             nextText:'Suivant',
             currentText:"Aujourd'hui",
             monthNames:['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Decembre'],
             monthNamesShort:['Jan','Fev','Mars','Avr','Mai','Juin','Juill','Août','Sept','Oct','Nov','Dec'],
             dayNames:['Dichanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
             dayNamesShort:['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
             dayNamesMin:['D','L','M','M','J','V','S'],
             weekHeader:'sem'
          });
    
          $('#anneeClassement').datepicker({
            dateFormat: 'yy',  changeYear: true,  changeMonth: false
         });
     </script>
</html>


