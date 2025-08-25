<!-- Vue create pour VenteComptantCredit -->
@extends('layouts.template')

@section('content')
    <div class="container-fluid" >
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header py-0">{{ __('Ajouter nouvelle vente') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('venteComptantCredits.store') }}" id="formArticle">
                            @csrf
                            {{-- bloc type vente & client --}}
                            <fieldset class="border p-3 mb-2 position-relative">
                                <legend class="position-absolute top-0 start-0 translate-middle-y bg-white px-2" style="font-size: 1rem;"> {{__('Informations types ventes')}}</legend>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="typeVente_id"> {{ __('Type vente')}} <span style="color: red">*</span></label>
                                        <select name="typeVente_id" class="form-control" id="typeVente_id" required >
                                            <option value="">-- Sélectionner --</option>
                                            @foreach($data_typeVente as $items)
                                                <option value="{{ $items->typeVente_id }}">
                                                    {{ $items->libelleTypeVente }}
                                                </option>
                                            @endforeach     
                                        </select> 
                                        <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                        </div>
                                        @error('typeVente_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-7"></div>
                                    <div class="col-md-2">
                                        <label for="dateVente">{{ __('Date vente')}}<span style="color: red">*</span></label>
                                        <input type="date" name="dateVente" id="dateVente" class="form-control" required>
                                        <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                        </div>
                                        @error('dateVente')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror   
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="typeClient_id"> {{ __('Type client')}} <span style="color: red">*</span></label>
                                        <select name="typeClient_id" class="form-control" onchange="getInfoClient(this.id)" id="typeClient_id" required >
                                            <option value="">-- Sélectionner --</option>
                                            @foreach($data_typeClient as $items)
                                                <option value="{{ $items->typeClient_id }}">
                                                    {{ $items->libelleTypeClient }}
                                                </option>
                                            @endforeach     
                                        </select> 
                                        <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                        </div>
                                        @error('typeClient_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-9"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <label for="client_id"> {{ __('Nom client')}} <span style="color: red">*</span></label>
                                        <select name="client_id" class="form-control" id="client_id" required >
                                            <option value="">-- Sélectionnez --</option>
                                            {{-- affiche la liste des clients --}}
                                        </select> 
                                        <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                        </div>
                                        @error('client_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-1">

                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                            </fieldset><br>

                            {{-- Bloc articles --}}
                            <fieldset class="border p-3 mb-2 position-relative">
                                <legend class="position-absolute top-0 start-0 translate-middle-y bg-white px-2" style="font-size: 1rem;">{{__('Informations articles')}}</legend>
                                    <div id="zoneArticle">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="typeArticle_id[]">{{ __('Type article')}} <span style="color: red">*</span></label>
                                                    <select name="typeArticle_id[]" class="form-control" onchange="getArticleByType('article_id[]',this.id,'0')" id="typeArticle_id" required>
                                                        <option value="">-- Sélectionner --</option>
                                                        @foreach($data_typeArticle as $items)
                                                            <option value="{{ $items->typeArticle_id }}">
                                                                {{ $items->libelleTypeArticle }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{__('formulaire.Obligation')}}
                                                    </div>
                                                    @error('typeArticle_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <label for="article">{{ __('Nom article')}} <span style="color: red">*</span></label>
                                                    <select name="article_id[]" class="form-control" id="article_0" onchange="getInfoQte(this.id,'0')" required>
                                                        <option value="">-- Sélectionner --</option>
                                                        {{-- liste des articles --}}
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{__('formulaire.Obligation')}}
                                                    </div>
                                                    @error('article_id[]')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                            <div class="col-md-1">
                                                <label for="qteRestant">{{ __('Qte rest')}}</label>
                                                <input type="number" id="qteRestant_0" name="qteRestant[]" class="form-control" readonly>
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('qteRestant')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror   
                                            </div>
                                            <div class="col-md-2">
                                                <label for="prixVente">{{ __('PU Vente')}}</label>
                                                <input type="number" id="prixVente_0" name="prixVente[]" class="form-control" onchange="getMontantByQtePU(this.id,'0')">
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('prixVente')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror  
                                            </div>
                                            <div class="col-md-1">
                                                <label for="qteVente">{{ __('Qte Sor')}}<span style="color: red">*</span></label>
                                                <input type="number" id="qteVente_0" name="qteVente[]" class="form-control" onchange="getMontantByQtePU(this.id,'0')">
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('qteVente')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror   
                                            </div>
                                            <div class="col-md-2">
                                                <label for="mtHtVente">{{ __('Montant total')}}</label>
                                                <input type="mtHtVente" id="mtHtVente_0" readonly name="mtHtVente[]" class="form-control">
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('mtHtVente')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror   
                                            </div>
                                        </div>
                                    </div>
                                <a href="#" class="btn btn-primary" onclick="getArticleForm('article_id[]','/getTypeArticleByArticle','zoneArticle')"><i class="fas fa-plus"></i></a>
                            </fieldset>

                            {{-- Bloc Infos Montants --}}
                           <fieldset class="border p-3 mb-2 position-relative">
                            <legend class="position-absolute top-0 start-0 translate-middle-y bg-white px-2" style="font-size: 1rem;">{{__('Informations montants')}}</legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="mtTotalVente">{{ __('Montant brut')}}</label>
                                                <input type="number" id="mtTotalVente" name="mtTotalVente" class="form-control readonly" readonly>
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('mtTotalVente')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror 
                                    </div>
                                    <div class="col-md-2">
                                        <label for="remise_id">{{ __('Taux remise')}}<span style="color: red">*</span></label>
                                                <select name="remise_id" class="form-select" id="remise" onchange="tauxRemise(this.id)" required>
                                                    <option value="">-- Sélectionner --</option>
                                                    @foreach($data_remise as $items)
                                                        <option value="{{ $items->remise_id }}">
                                                            {{ $items->tauxRemise }}
                                                        </option>
                                                    @endforeach     
                                                </select> 
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('remise_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror  
                                    </div>
                                    <div class="col-md-2">
                                        <label for="mtRemiseVente">{{ __('Montant remise')}}</label>
                                                <input type="number" id="mtRemiseVente" name="mtRemiseVente" class="form-control" readonly>
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('mtRemiseVente')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror  
                                    </div>
                                    <div class="col-md-2">
                                        <label for="taxe_id">{{ __('Taux TVA')}}<span style="color: red">*</span></label>
                                                <select name="taxe_id" class="form-select" id="taxe" onchange="tauxTaxe(this.id)" required>
                                                    <option value="#">-- Sélectionner --</option>
                                                    @foreach($data_taxe as $items)
                                                        <option value="{{ $items->taxe_id }}">
                                                            {{ $items->tauxTva}}
                                                        </option>
                                                    @endforeach     
                                                </select> 
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('taxe_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label for="mtTvaVente">{{ __('Montant TVA')}}</label>
                                                <input type="number" id="mtTvaVente" name="mtTvaVente" class="form-control" readonly>
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('mtTvaVente')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror  
                                    </div>
                                     <div class="col-md-2">
                                        <label for="mtNetVente">{{ __('Montant net payer')}}</label>
                                                <input type="number" id="mtNetVente" name="mtNetVente" class="form-control" readonly>
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('mtNetVente')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror  
                                    </div>
                                </div>                  
                           </fieldset><br>

                        {{-- Bloc mode reglement --}}
                        <fieldset class="border p-3 mb-2 position-relative">
                            <legend class="position-absolute top-0 start-0 translate-middle-y bg-white px-2" style="font-size: 1rem;"> {{__('Informations modes règlement')}}</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="modeReglement_id"> {{ __('Mode règlement')}} <span style="color: red">*</span></label>
                                        <select name="modeReglement_id" class="form-select" id="modeReglement_id" required >
                                            <option value="">-- Sélectionner --</option>
                                            @foreach($data_modeReglement as $items)
                                                <option value="{{ $items->modeReglement_id }}">
                                                    {{ $items->libelleModeReglement }}
                                                </option>
                                            @endforeach     
                                        </select> 
                                        <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                        </div>
                                        @error('modeReglement_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="reference"> {{__('Références')}} </label>
                                        <textarea type="text" rows="2" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="reference" id="reference"
                                            placeholder="reference"> </textarea>
                                         <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                        </div>
                                        @error('reference')
                                            <span class="invalid-feedback"> {{$message}}</span>
                                        @enderror
                                </div>
                                <div class="col-md-5"></div>
                            </div>
                        </fieldset>

                            {{-- Boutons --}}
                            <div class="form-group row mb-0 mt-4">
                                <input type="hidden" name="rub" value="{{ $rub }}">
                                <input type="hidden" name="srub" value="{{ $srub }}">    
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" id="valider" class="btn btn-primary btnEnregistrer">{{ __('Enregistrer') }}</button>
                                    <a href="{{route('venteComptantCredits.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .input-uniform {
        width: 50%;
        max-width: 300px; /* ou toute valeur */
    }
</style>

@endsection




