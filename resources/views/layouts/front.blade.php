<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Carto-Web</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        {{-- <link rel="preconnect" href="https://fonts.googleapis.com"> --}}
        {{-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> --}}
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Saira:wght@500;600;700&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{ asset('lib/animate/animate.min.css')}}" rel="stylesheet">
        <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- Font Icon -->
        {{-- <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css"> --}}
        <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
        <!-- Template Stylesheet -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/jquery.rtnotify.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sigobs.css')}}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{asset('images/favicon.png')}}" type="image/x-icon"/>

                <!-- Intégration de Leaflet -->
        <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}">
    </head>
    <body>
        <!-- Spinner Start -->
        <div id="envoi"></div>
        <div id="spinner" class="show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->

        <!-- Topbar Start -->
        <div class="container-fluid bg-dark py-2 d-none d-md-flex">
            <div class="container">
                <div class="d-flex justify-content-between topbar">
                    <div class="top-info">
                        <small class="me-3 text-white-50"><a href="#"><i class="fas fa-map-marker-alt me-2 text-secondary"></i></a>BP 10 Ouagadougou</small>
                        <small class="me-3 text-white-50"><a href="#"><i class="fas fa-envelope me-2 text-secondary"></i></a>contacts@contacts.com</small>
                    </div>
                    <div id="note" class="text-secondary d-none d-xl-flex"><small>Carto-Web</small></div>
                    <div class="top-link">
                        <a href="" class="bg-light nav-fill btn btn-sm-square rounded-circle"><i class="fab fa-facebook-f text-primary"></i></a>
                        <a href="" class="bg-light nav-fill btn btn-sm-square rounded-circle"><i class="fab fa-twitter text-primary"></i></a>
                        <a href="" class="bg-light nav-fill btn btn-sm-square rounded-circle"><i class="fab fa-instagram text-primary"></i></a>
                        <a href="" class="bg-light nav-fill btn btn-sm-square rounded-circle me-0"><i class="fab fa-linkedin-in text-primary"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar End -->

        <!-- Navbar Start -->
        <div class="container-fluid bg-primary">
            <div class="container-fluid">
                <nav class="navbar navbar-dark navbar-expand-lg py-0">
                    <img class="logo" src="{{asset('images/logo.png')}}" alt="Logo" srcset="" width="50" height="50">
                    <a href="/" class="navbar-brand">
                        <h1 class="text-white fw-bold d-block">Carto<span class="text-secondary">-Web</span> </h1>
                    </a>
                    <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-transparent" id="navbarCollapse">
                        <div class="navbar-nav ms-auto mx-xl-auto p-0">
                            <a href="/" class="nav-item nav-link active text-secondary">Acceuil</a>
                            <a href="/explorer" class="nav-item nav-link secondaire text-secondary">Explorer</a>
                             <a href="/" class="nav-item nav-link secondaire text-secondary">Indicateur</a>
                              <a href="/" class="nav-item nav-link secondaire text-secondary">Aide</a>
                            @auth
                                @foreach (session('menusFront') as $key=>$item)
                                @php $route= "route" ; @endphp
                                    <div class="nav-item dropdown">
                                        @if (!empty($item[1]) )
                                        <a class="nav-link dropdown-toggle show" href="#" data-bs-toggle="dropdown" aria-expanded="true">{{$item[0]->nomMenu}}</a>
                                        <div class="dropdown-menu bg-light m-0 show" data-bs-popper="none">
                                            @foreach ($item[1] as $skey => $sousMenu)
                                                <a href="{{ $route($sousMenu[0]->lien)  }}/{{$item[0]->menu_id}}/{{$sousMenu[0]->menu_id}}" class="dropdown-item" id="sousMenuFront{{$sousMenu[0]->menu_id}}">{{$sousMenu[0]->nomMenu}}</a>
                                            @endforeach
                                        </div>
                                        @else
                                            <a @if($item[0]->lien!="") href="{{ $route($item[0]->lien)  }}/{{$item[0]->menu_id}}"@else href="#" @endif class="nav-item nav-link">{{$item[0]->nomMenu}}</a>
                                        @endif
                                    </div>
                                {{-- --}}
                                @endforeach
                            @endauth
                            
                            
                            {{-- <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle show" href="#" data-bs-toggle="dropdown" aria-expanded="true">Pages</a>
                                <div class="dropdown-menu bg-light m-0 show" data-bs-popper="none">
                                    <a href="" class="dropdown-item">page 1</a>
                                    <a href="" class="dropdown-item">page 2</a>
                                </div>
                            </div> --}}
                            @guest
                                <a href="{{ route('login') }}" class="nav-item nav-link">Se connecter</a> 
                            @else
                                <div class="nav-item dropdown pull-right">
                                    <a class="nav-link dropdown-toggle show" href="#" data-bs-toggle="dropdown"
                                        aria-expanded="true">{{ __('Mon compte') }}</a>
                                    <div class="dropdown-menu dropdown-menu-end bg-light m-0 show py-3" data-bs-popper="none">
                                        <a href="{{ route('dashboard') }}" class="dropdown-item text-center">Espace de
                                            travail</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="#"
                                                onclick="event.preventDefault();
                                                                                        this.closest('form').submit();"
                                                class="dropdown-item">
                                                <div class="dropdown-divider"></div>
                                                <i class="fas fa-sign-out-alt"></i>
                                                {{ __('Se déconnecter') }}
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            @endguest
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->
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
        <div class="container">
            @yield('content')
        </div>
        <!-- Footer Start -->
         <div class="container-fluid footer bg-dark wow fadeIn" data-wow-delay=".3s">
            <div class="container pt-5 pb-4">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <a href="/">
                            <h1 class="text-white fw-bold d-block">Carto<span class="text-secondary">Web</span> </h1>
                        </a>
                        <p class="mt-4 text-light">Système Carto-Web</p>
                        <div class="d-flex hightech-link">
                            <a href="" class="btn-light nav-fill btn btn-square rounded-circle me-2"><i class="fab fa-facebook-f text-primary"></i></a>
                            <a href="" class="btn-light nav-fill btn btn-square rounded-circle me-2"><i class="fab fa-twitter text-primary"></i></a>
                            <a href="" class="btn-light nav-fill btn btn-square rounded-circle me-2"><i class="fab fa-instagram text-primary"></i></a>
                            <a href="" class="btn-light nav-fill btn btn-square rounded-circle me-0"><i class="fab fa-linkedin-in text-primary"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="#" class="h3 text-secondary">Liens</a>
                        <div class="mt-4 d-flex flex-column short-link">
                            <a href="" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>About us</a>
                            <a href="" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Contact us</a>
                            <a href="" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Our Services</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="#" class="h3 text-secondary">Autres Liens</a>
                        <div class="mt-4 d-flex flex-column help-link">
                            <a href="" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Terms Of use</a>
                            <a href="" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Privacy Policy</a>
                            <a href="" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Helps</a>
                            {{-- <a href="" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>FQAs</a>
                            <a href="" class="mb-2 text-white"><i class="fas fa-angle-right text-secondary me-2"></i>Contact</a> --}}
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="#" class="h3 text-secondary">Contactez Nous</a>
                        <div class="text-white mt-4 d-flex flex-column contact-link">
                            <a href="#" class="pb-3 text-light border-bottom border-primary"><i class="fas fa-map-marker-alt text-secondary me-2"></i> BP Ouagadougou</a>
                            <a href="#" class="py-3 text-light border-bottom border-primary"><i class="fas fa-phone-alt text-secondary me-2"></i> +226 00000000</a>
                            <a href="#" class="py-3 text-light border-bottom border-primary"><i class="fas fa-envelope text-secondary me-2"></i> contact@contact.com</a>
                        </div>
                    </div>
                </div>
                <hr class="text-light mt-5 mb-4">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        <span class="text-light"><a href="#" class="text-secondary"><i class="fas fa-copyright text-secondary me-2"></i>{{ date('Y') }} WEBMAPPING</a>, Tout droit réservé.</span>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        <span class="text-light">Designed By<a href="#" class="text-secondary">DSI</a></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
        <div id="apercuDoc" class="modal fade"  data-bs-backdrop="static">
            <div class="modal-dialog" role="document" style="width: 1000px; max-width: 1200px;">
                <div class="modal-content" style="height:600px">
                    <div class="modal-header entetePopup">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{__('Aperçu du document')}}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="docZone" >    
                       
                    </div>
                    <div class="modal-footer">
                        <input type="submit" id="validerArret" style="display: none"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                        <button type="button" class="btn btn-primary btnAnnuler" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

         <!-- Integration du Js de Mapleaflet-->
        <script src="{{ asset('js/leaflet.js') }}"></script>
        <!-- Back to Top -->
        <a href="#" class="btn btn-secondary btn-square rounded-circle back-to-top"><i class="fa fa-arrow-up text-white"></i></a>
        {{-- <script src="{{ mix('js/app.js') }}"></script> --}}

        <script src="{{ asset('js/jquery-1.10.2.min.js') }}"></script>
        <!-- JavaScript Libraries -->
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

        <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
        <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
        
        {{-- <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-validation/dist/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-validation/dist/additional-methods.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-steps/jquery.steps.min.js') }}"></script>
        <script src="{{ asset('vendor/minimalist-picker/dobpicker.js') }}"></script>
        <script src="{{ asset('vendor/nouislider/nouislider.min.js') }}"></script>
        <script src="{{ asset('vendor/wnumb/wNumb.js') }}"></script> --}}
        
        <script src="{{ asset('js/jquery.rtnotify.js') }}"></script>
        <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('js/inputmask/jquery.inputmask.min.js')}}"></script>
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/select2.full.min.js') }}"></script>
        <script src="{{ asset('js/fr.js') }}"></script>
        <script src="{{ asset('js/table.js') }}"></script>
        <script src="{{ asset('js/chargerFichier.js') }}"></script>
        <script src="{{ asset('js/scriptAjax.js') }}"></script>
        <script src="{{ asset('js/sigobs.js') }}"></script>
        <!-- Template Javascript -->
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('js/pdfobject.js') }}"></script>
        {{-- <script src="js/global.js"></script> --}}
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
    </body>

</html>