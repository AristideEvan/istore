<!DOCTYPE html>
<html lang="fr">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Carto-Web') }}</title>

        {{-- <link rel="stylesheet" href="{{mix("css/app.css")}}" /> --}}
       {{--  @vite(['public/css/app.css', 'public/js/app.js']) --}}
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/jquery.rtnotify.css') }}">
        <link rel="stylesheet" href="{{asset("css/sigobs.css")}}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{asset('images/favicon.png')}}" type="image/x-icon"/>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="se-pre-con"></div>  
        <div id="envoi"></div>
        <!-- entete <body entete> -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light pushmenu">
            {{-- Outiel a gauche --}}
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                {{-- ------------------------ Afficher la date et l heure ------------------------------------ --}}
            <li class="nav-item">
                <h5 class="nav-link active " id="dateheure" ></h5>
            </li>
                <script>
                function pause(ms) 
                {
                    return new Promise(resolve => setTimeout(resolve, ms));
                }
                async function afficherDate() 
                {
                    while(true) 
                    {
                    await pause(1000);
                    var cejour = new Date();
                    var options = {weekday: "long", year: "numeric", month: "long", day: "2-digit"};
                    var date = cejour.toLocaleDateString("fr-FR", options);
                    var heure = ("0" + cejour.getHours()).slice(-2) + ":" + ("0" + cejour.getMinutes()).slice(-2) + ":" + ("0" + cejour.getSeconds()).slice(-2);
                    var dateheure = date + "  |  " + heure;
                    var dateheure = dateheure.replace(/(^\w{1})|(\s+\w{1})/g, lettre => lettre.toUpperCase());
                    document.getElementById('dateheure').innerHTML = dateheure;
                    }
                }
                afficherDate();
                </script> 
                {{-- ----------------------------------------------------------------- --}}
            </ul>
            <!-- outiel a droite -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-user"></i>
                </a>
                </li>
            </ul>
        </nav>
                <!-- Menu -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <div>
                <a href="/">
                    <img class="armoirieimg mt-1" src="{{asset('images/logo.png')}}" alt="Logo">
                </a>
                <hr color="#708090">
            </div>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-1 pb-2 mb-3 d-flex">
                    <h6 class="nameuser retouralaligne" color="#ffffff">{{ Auth()->user()->identifiant}}</h6>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        @foreach (session('menus') as $key=>$item)
                            <li class="nav-item parent" id="colapse-{{ $item[0]->menu_id }}" onclick="Collapser(this.id);" style="margin-bottom: 3px">
                                <a href="#" class="nav-link titreMenu majuscule bg-success text-white" id="heading{{ $item[0]->menu_id }}">
                                <i class="nav-icon {{$item[0]->icon}}"></i>
                                <p>
                                    {{$item[0]->nomMenu}}
                                    <i class="fas fa-angle-double-left right"></i>
                                </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if (!empty($item[1]) )
                                        @foreach ($item[1] as $skey => $sousMenu)
                                            @php $test= "route" ; @endphp
                                            <li class="nav-item">
                                                <a href="{{ $test($sousMenu[0]->lien)  }}/{{$item[0]->menu_id}}/{{$sousMenu[0]->menu_id}}" id="sousMenu{{$sousMenu[0]->menu_id}}">
                                                    <i class="metismenu-icon"></i>
                                                    <p style="margin-left: 10%">{{$sousMenu[0]->nomMenu}}</p>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                        {{-- Deconnexion --}}
                        <br>
                        <li class="nav-item d-flex justify-content-center">
                            <a class="btn btn-danger" href="{{ route('logout') }}" 
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{-- <i class="nav-icon fas fa-th"></i> --}}
                                <i class=" nav-icon fa-solid fa-right-from-bracket"></i>
                                {{-- {{ __('Déconnexion ') }} --}}
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form> 
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Contenu de la page <body main> -->
        <!-- Main content -->
        <div class="  content-wrapper">
            <div class="content">
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
                <!-- /.container-fluid -->
            </div>
        </div>
        <!-- informations utilisateur -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="bg-dark">
                <div class="card-body bg-dark box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('images/avatar.png') }}" alt="User profile picture">
                </div>
                <h3 class="profile-username text-center retouralaligne">{{ Auth()->user()->prenom}} {{ Auth()->user()->nom}} </h3>
               {{--  <h6 class="text-muted text-center retouralaligne">{{ getRole()}}</h6> --}}
                <ul class="list-group bg-dark mb-3">
                    <li class="list-group-item">
                        <a href="#" class="d-flex align-items-center"><i class="fa fa-user-circle pr-2"></i><b class="retouralaligne">{{Auth()->user()->identifiant}}</b> </a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" class="d-flex align-items-center"><i class="fa fa-envelope pr-2"></i><b class="retouralaligne">{{Auth()->user()->email}}</b> </a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" class="d-flex align-items-center"><i class="fa-solid fa-phone pr-2"></i><b class="retouralaligne">{{Auth()->user()->telephone}}</b> </a>
                    </li>
                </ul>
                    <a class="btn btn-danger d-flex justify-content-center" href="{{ route('logout') }}" 
                      onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                          <i class=" nav-icon fa-solid fa-right-from-bracket"></i>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                      </form> 
                    </a>
                </div>
            </div>
        </aside>
        <!-- piedpage  <body piedpage>-->
        <footer class="main-footer ">
            <div class="d-flex justify-content-center ">
                <strong class="mr-1">Copyright &copy; </strong> <?php $year= date("Y"); echo" <strong > | 2024-$year|</strong>" ;?> <a class="mr-2 ml-2" href="tel:+22664610959"><img  width="50" height="50" src="{{asset('images/logo.png')}}" alt="Logo"></a><a href="#">| Carto-Web - tous droits réservés</a>.
            </div>
        </footer>
        {{-- <footer class="main-footer">
            <strong class="mr-2">Copyright &copy; </strong> <?php $year= date("Y"); echo" <strong > |$year|</strong>" ;?> <a class="mr-2 ml-2" href="tel:+22670147315"><img  width="50" height="50" src="{{asset('images/armoirie2.jpg')}}"></a><a href="#">|Projet Repas tous droits réservés</a>.
            <div class="float-right d-none d-sm-inline-block">
              <b>Version</b> 1.0
            </div>
        </footer> --}}

        <div class="modal" id="suppModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="suppFileModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header suppModel">
                  <h5 class="modal-title" id="suppFileModalLabel">{{__('Confirmer la suppression')}}</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="form-horizontal" id="pourSupp" >
                            <!--verbes-->
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-md-12" style="text-align:center; font-size:15pt;">
                                        <!--fichier de langue-->
                                    {{__('Etes vous sûre de vouloir supprimer cet élément?')}}
                                            <br>
                                    <small id="nb" style="color:red; font-size: 50%; font-weight: 800;"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="AnnulerSuppFile" >Annuler</button>
                            <input type="submit" class="btn btn-primary" style="background-color:#F00" value="Supprimer"/>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="changeEtatModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="changeEtatModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 500px;">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="validModalLabel">{{ __("Changer d'état") }}</h4>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="form-horizontal" id="changeEtat">
                        {{csrf_field()}}
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-md-12" style="text-align:center; font-size:15pt;">
                                    <!--fichier de langue-->
                                    Êtes vous sûr de vouloir changer {{ __("l'état ") }}
                                    <span id="zoneMessage"></span>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <input type="submit" class="btn btn-primary" style="background-color:#060" value="Valider"/>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>

        <div id="apercuDoc" class="modal"  data-backdrop="static">
            <div class="modal-dialog" role="document" style="width: 1000px; max-width: 1200px;">
                <div class="modal-content" style="height:600px">
                    <div class="modal-header entetePopup">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{__('Aperçu du document')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="docZone" >    
                       
                    </div>
                    <div class="modal-footer">
                        <input type="submit" id="validerArret" style="display: none"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                        <button type="button" class="btn btn-primary btnAnnuler" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="loader" class="modal"  data-backdrop="static">
            <div class="modal-dialog" role="document" style="width: 100px; max-width: 100px;">
                <div class="modal-content">
                    <div class="modal-body" id="docZone" style="text-align: center">    
                        <img src="{{ asset('images/Preloader_11.gif') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="popupAlert" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="popupAlertModalLabel" aria-hidden="true">
            <div id="detailChe"></div>
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="suppModalLabel">{{__('infos')}}</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-md-12" style="text-align:center; font-size:15pt;" >
                                <p id="zoneMessage"></p>
                            </div>
                        </div>
                    </div>
                   {{--  <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div> --}}
                </div>
              </div>
            </div>
        </div>
          
        <!-- REQUIRED SCRIPTS -->
        <script src="{{ asset('js/app.js') }}"></script>
        
        <script src="{{ asset('js/jquery-1.10.2.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{asset('js/popper.js')}}"></script> 
        
        <script type="text/javascript" src="{{ asset('js/main.js') }}" defer></script>
        <script src="{{ asset('js/inputmask/jquery.inputmask.min.js')}}"></script>
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/jquery.rtnotify.js') }}"></script>
        <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('js/select2.full.min.js') }}"></script>
        <script src="{{ asset('js/fr.js') }}"></script>
        <script src="{{ asset('js/pdfobject.js') }}"></script>
        <script src="{{ asset('js/table.js') }}"></script>
        <script src="{{ asset('js/chargerFichier.js') }}"></script>
        <script src="{{ asset('js/scriptAjax.js') }}"></script>
        <script src="{{ asset('js/sigobs.js') }}"></script>
       
       {{--  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script> --}}
        <script>
            $(window).load(function () {
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