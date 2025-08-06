<!-- Vue edit pour Fournisseur -->
@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Modifier fournisseur') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('fournisseurs.update',$data->fournisseur_id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                
                                <label for="nomFournisseur" class="col-md-4 col-form-label text-md-right">{{ __('Nom fournisseur') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="nomFournisseur" type="text" class="form-control @error('nomFournisseur') is-invalid @enderror" name="nomFournisseur"
                                    value="{{ $data->nomFournisseur }}" required autocomplete="nomFournisseur" autofocus onkeyup="this.value = this.value.toUpperCase();">
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('nomFournisseur')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <label for="telephoneFournisseur" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="telephoneFournisseur" type="text" class="form-control @error('telephoneFournisseur') is-invalid @enderror" name="telephoneFournisseur"
                                    value="{{ $data->telephoneFournisseur }}" required autocomplete="telephoneFournisseur" autofocus onkeyup="this.value = this.value.toUpperCase();">
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('telephoneFournisseur')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <label for="adresseFournisseur" class="col-md-4 col-form-label text-md-right">{{ __('Adresse') }}</span></label>
                                <div class="col-md-6">
                                    <input id="adresseFournisseur" type="text" class="form-control @error('adresseFournisseur') is-invalid @enderror" name="adresseFournisseur"
                                    value="{{ $data->adresseFournisseur }}"  autocomplete="adresseFournisseur" autofocus onkeyup="this.value = this.value.toUpperCase();">
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('adresseFournisseur')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <label for="emailFournisseur" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</span></label>
                                <div class="col-md-6">
                                    <input id="emailFournisseur" type="email" class="form-control @error('emailFournisseur') is-invalid @enderror" name="emailFournisseur"
                                    value="{{ $data->emailFournisseur }}" autocomplete="emailFournisseur" autofocus onkeyup="this.value = this.value.toUpperCase();">
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('emailFournisseur')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <label for="numeroIdentifiant" class="col-md-4 col-form-label text-md-right">{{ __('Numéro identidiant') }}</span></label>
                                <div class="col-md-6">
                                    <input id="numeroIdentifiant" type="text" class="form-control @error('numeroIdentifiant') is-invalid @enderror" name="numeroIdentifiant"
                                    value="{{ $data->numeroIdentifiant }}" autocomplete="numeroIdentifiant" autofocus onkeyup="this.value = this.value.toUpperCase();">
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('numeroIdentifiant')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <label for="typeFournisseur_id" class="col-md-4 col-form-label text-md-right">{{ __('Type fournisseur') }}</label>
                                <div class="col-md-6">
                                    <select id="typeFournisseur_id" class="form-control @error('typeFournisseur_id') is-invalid @enderror" name="typeFournisseur_id" required>
                                        <option value="">{{ __('Sélectionner') }}</option>
                                        @foreach ($data_typeFournisseur as $items)
                                            <option value="{{ $items->typeFournisseur_id }}" {{ $data->typeFournisseur_id == $items->typeFournisseur_id ? 'selected' : '' }}>
                                                {{ $items->libelleTypeFournisseur }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('formulaire.Obligation') }}
                                    </div>
                                    @error('typeFournisseur_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <input type="hidden" name="rub" value={{$rub}} >
                                <input type="hidden" name="srub" value={{$srub}} >
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
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