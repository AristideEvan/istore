<!-- Vue create pour Ravitaillement -->
@extends('layouts.template')

@section('content')
    <div class="container-fluid" >
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header py-0">{{ __('Approvisionner stock') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('ravitaillements.store') }}" id="formArticle">
                            @csrf

                            {{-- Date de ravitaillement --}}
                            <div class="form-group text-right" style="width: 150px; float: right;">
                                <label for="dateRavi" class="d-block text-right">Date <span class="text-danger">*</span></label>
                                <input type="date" name="dateRavi" id="dateRavi" class="form-control @error('devise') is-invalid @enderror  text-right" required>
                                     <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                     </div>
                                    @error('dateRavi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror   
                            </div><br><br><br><br>

                            {{-- Bloc Infos Fournisseur --}}
                            <fieldset class="border p-3 mb-2 position-relative">
                                <legend class="position-absolute top-0 start-0 translate-middle-y bg-white px-2" style="font-size: 1rem;">Informations fournisseurs</legend>

                                <div class="row g-3 align-items-end pt-4">
                                    <div class="col-md-4">
                                        <label for="fournisseur_id">Nom fournisseur <span class="text-danger">*</span></label>
                                        <select name="fournisseur_id" onchange="getInfoFournisseur(this.id)" class="form-control" id="fournisseur_id" required >
                                            <option value="">-- Sélectionner --</option>
                                            @foreach($data_fournisseur as $items)
                                                <option value="{{ $items->fournisseur_id }}">
                                                    {{ $items->nomFournisseur }}
                                                </option>
                                            @endforeach     
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="telephoneFournisseur">Téléphone</label>
                                        <input type="text" id="telephoneFournisseur" name="telephoneFournisseur" class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="numeroIdentifiant">Numéro identifiant</label>
                                        <input type="text" id="numeroIdentifiant" name="numeroIdentifiant" class="form-control">
                                    </div>
                                </div>
                            </fieldset><br>


                            {{-- Bloc Infos Magasin --}}
                            <fieldset class="border p-3 mb-2 position-relative">
                                <legend class="position-absolute top-0 start-0 translate-middle-y bg-white px-2" style="font-size: 1rem;">Informations magasins</legend>
                                <div class="row g-3 align-items-end pt-4">
                                    <div class="col-md-6">
                                        <label for="magasin_id">Nom magasin <span class="text-danger">*</span></label>
                                        <select name="magasin_id" class="form-control" id="magasin_id" onchange="getInfoMagasin(this.id)" required>
                                            <option value="">-- Sélectionner --</option>
                                            @foreach($data_magasin as $items)
                                                <option value="{{ $items->magasin_id }}">
                                                    {{ $items->nomMagasin }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="capacite">Capacité</label>
                                        <input type="text" id="capacite" class="form-control">
                                    </div>
                                </div>
                            </fieldset><br>

                            {{-- Bloc Infos article --}}
                            <fieldset class="border p-3 mb-2 position-relative">
                                <legend class="position-absolute top-0 start-0 translate-middle-y bg-white px-2" style="font-size: 1rem;">Informations articles</legend>
                                        <div id="zoneArticle">
                                            <div class="row g-3 align-items-end pt-4">
                                                <div class="col-md-5">
                                                    <label for="article_id[]">Nom article <span class="text-danger">*</span></label>
                                                    <select name="article_id[]" class="form-control" id="article" required>
                                                        <option value="">-- Sélectionner --</option>
                                                        @foreach($data_article as $items)
                                                            <option value="{{ $items->article_id }}">
                                                                {{ $items->libelleArticle }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="qteRavi[]">Quantité <span class="text-danger">*</span></label>
                                                    <input type="number" id="qteRavi" class="form-control" name="qteRavi[]" required>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="prixAchatRavi[]">PU achat</label>
                                                    <input type="number" id="prixAchatRavi" class="form-control" name="prixAchatRavi[]">
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="modeAchat_id[]">Mode achat <span class="text-danger">*</span></label>
                                                    <select name="modeAchat_id[]" class="form-control" id="modeAchat" required>
                                                        <option value="">-- Sélectionner --</option>
                                                        @foreach($data_modeAchat as $items)
                                                            <option value="{{ $items->modeAchat_id }}">
                                                                {{ $items->libelleModeAchat }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                <a href="#" class="btn btn-primary" onclick="getArticleForm('article_id[]','/getArticle','zoneArticle')"><i class="fas fa-plus"></i></a>
                            </fieldset>

                            {{-- Boutons --}}
                            <div class="form-group row mb-0 mt-4">
                                <input type="hidden" name="rub" value="{{ $rub }}">
                                <input type="hidden" name="srub" value="{{ $srub }}">    
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" id="valider" class="btn btn-primary btnEnregistrer">{{ __('Enregistrer') }}</button>
                                    <a href="{{route('ravitaillements.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


