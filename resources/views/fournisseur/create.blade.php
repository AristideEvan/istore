<!-- Vue create pour Fournisseur -->
@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter un fournisseur') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('fournisseurs.store') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="nomFournisseur"> Nom fournisseur <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" required onkeyup="this.value = this.value.toUpperCase();" name="nomFournisseur" id="nomFournisseur"
                                            placeholder="Nom fournisseur";><br>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="telephoneFournisseur"> Téléphone <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" required onkeyup="this.value = this.value.toUpperCase();" name="telephoneFournisseur" id="telephoneFournisseur"
                                            placeholder="Téléphone";><br>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="adresseFournisseur"> Adresse </label>
                                        <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="adresseFournisseur" id="adresseFournisseur"
                                            placeholder="Adresse"> <br>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="emailFournisseur"> Email </label>
                                        <input type="email" class="form-control" name="emailFournisseur" id="emailFournisseur"
                                            placeholder="Email"> <br>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="numeroIdentifiant"> Numéro identifiant </label>
                                        <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="numeroIdentifiant" id="numeroIdentifiant"
                                            placeholder="Numéro identifiant"> <br>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="typeFournisseur_id">Type fournisseur <span style="color: red">*</span></label>
                                            <select name="typeFournisseur_id" class="form-control" required>
                                                <option value="">-- Sélectionner --</option>
                                                @foreach($data_typeFournisseur as $items)
                                                    <option value="{{ $items->typeFournisseur_id }}">{{ $items->libelleTypeFournisseur }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="form-group row mb-0 mt-4">
                                <input type="hidden" name="rub" value="{{ $rub }}">
                                <input type="hidden" name="srub" value="{{ $srub }}">    
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" id="valider" class="btn btn-primary btnEnregistrer">{{ __('Enregistrer') }}</button>
                                    <a href="{{route('fournisseurs.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>

                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
