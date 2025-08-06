<!-- resources/views/welcome.blade.php -->

@extends('layouts.front')

@section('content')
        <!-- Carousel Start -->
    <div class="container-fluid px-0">
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" data-bs-wrap="true">
    <ol class="carousel-indicators">
        <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active" aria-label="Slide 1"></li>
        <li data-bs-target="#carouselId" data-bs-slide-to="1" aria-label="Slide 2"></li>
        <li data-bs-target="#carouselId" data-bs-slide-to="2" aria-label="Slide 3"></li>
    </ol>

    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
            <img src="images/carousel2.png" class="img-fluid w-100" alt="Slide 1">
            <div class="carousel-caption d-none d-md-block">
                <div class="container carousel-content">
                    <h6 class="text-secondary h4 animated fadeInUp">Bienvenue !!</h6>
                    <h1 class="text-white display-1 mb-4 animated fadeInRight">Visualisez et explorez des lieux</h1>
                    <p class="mb-4 text-white fs-5 animated fadeInDown">Une application de cartographie intelligente pour découvrir, analyser et interagir avec votre environnement.</p>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <img src="images/carousel1.png" class="img-fluid w-100" alt="Slide 2">
            <div class="carousel-caption d-none d-md-block">
                <div class="container carousel-content">
                    <h6 class="text-secondary h4 animated fadeInUp">Géolocalisation en temps réel</h6>
                    <h1 class="text-white display-1 mb-4 animated fadeInLeft">Localisez des lieux</h1>
                    <p class="mb-4 text-white fs-5 animated fadeInDown">Restez informé  où que vous soyez.</p>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <img src="images/carousel3.jpg" class="img-fluid w-100" alt="Slide 3">
            <div class="carousel-caption d-none d-md-block">
                <div class="container carousel-content">
                    <h6 class="text-secondary h4 animated fadeInUp">Analyse des données géospatiales</h6>
                    <h1 class="text-white display-1 mb-4 animated fadeInLeft">Prenez des décisions éclairées</h1>
                    <p class="mb-4 text-white fs-5 animated fadeInDown">Identifiez des tendances, des zones à risque ou des opportunités en exploitant les données géographiques.</p>
                </div>
            </div>
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
    </button>
</div>

        <!-- Carousel End -->
 <!-- Services Start -->
    <div class="container-fluid services py-5 mb-5">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
                <h5 class="text-primary">Infos</h5>
                <h1>Acceder à l'ensemble infos</h1>
            </div>
            <div class="row g-2 services-inner">

                <div class="row">
                    <div class="col-md-3 col-lg-3 wow fadeIn" data-wow-delay=".1s">
                        <div class="services-item bg-light">
                        <div class="p-4 text-center services-content">
                            <div class="services-content-icon">
                            <i class="fas fa-chart-bar fa-5x mb-2 text-primary"></i>
                            <h4 class="mb-1">Voir les indicateurs</h4>
                            <p>Consultez les indicateurs clés pour vos données géographiques.</p>
                            <a href="#" class="btn btn-secondary text-white px-3 py-2 rounded-pill">Détails</a>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 wow fadeIn" data-wow-delay=".2s">
                        <div class="services-item bg-light">
                        <div class="p-4 text-center services-content">
                            <div class="services-content-icon">
                            <i class="fas fa-balance-scale fa-5x mb-2 text-primary"></i>
                            <h4 class="mb-1">Comparer des statistiques</h4>
                            <p>Comparez différentes statistiques pour analyser vos données.</p>
                            <a href="#" class="btn btn-secondary text-white px-3 py-2 rounded-pill">Détails</a>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 wow fadeIn" data-wow-delay=".3s">
                        <div class="services-item bg-light">
                        <div class="p-4 text-center services-content">
                            <div class="services-content-icon">
                            <i class="fas fa-map-marked-alt fa-5x mb-2 text-primary"></i>
                            <h4 class="mb-1">Explorer la carte</h4>
                            <p>Visualisez vos données sur une carte interactive.</p>
                            <a href="#" class="btn btn-secondary text-white px-3 py-2 rounded-pill">Détails</a>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 wow fadeIn" data-wow-delay=".4s">
                        <div class="services-item bg-light">
                        <div class="p-4 text-center services-content">
                            <div class="services-content-icon">
                            <i class="fas fa-university fa-5x mb-2 text-primary"></i>
                            <h4 class="mb-1">Statistiques d'établissement</h4>
                            <p>Analysez les statistiques spécifiques aux établissements.</p>
                            <a href="#" class="btn btn-secondary text-white px-3 py-2 rounded-pill">Détails</a>
                            </div>
                        </div>
                        </div>
                    </div>
                 </div>
                 
                {{-- @foreach($bourses as $item)
                    <div class="col-md-3 col-lg-3 wow fadeIn" data-wow-delay=".3s">
                        <div class="services-item bg-light">
                            <div class="p-4 text-center services-content">
                                <div class="services-content-icon">
                                    <i class="fas fa-file-invoice-dollar fa-5x mb-2 text-primary"></i>
                                    <h4 class="mb-1">{{ $item->typeBourse}}</h4>
                                    <p>session {{$item->annee}}</p>
                                    <p>{{$item->concoursRattache}}</p>
                                    @if($item->forAll)<a href="{{ route('bourse.postuler',[$item->bourse_id,$rub,$srub]) }}" class="btn btn-secondary text-white px-1 py-1 rounded-pill">Postuler</a>@endif
                                    <a  href="{{ route('bourse.details',[$item->bourse_id,$rub,$srub]) }}"  class="btn btn-secondary text-white px-1 py-1 rounded-pill">détails</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach --}}
                
            </div>
        </div>
    </div>
        <!-- Services End -->
@endsection
