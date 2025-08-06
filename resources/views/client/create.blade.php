<!-- Vue create pour Client -->
@extends('layouts.template')
@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter client') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('clients.store') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="typeClient_id">Type client <span style="color: red">*</span></label>
                                            <select name="typeClient_id" id="" class="form-control" required><br>
                                                <option value="">-- Sélectionner --</option>
                                                @foreach($data_typeClient as $items)
                                                    <option value="{{ $items->typeClient_id }}">{{ $items->libelleTypeClient }}</option>
                                                @endforeach
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('typeClient_id')
                                                <span class="invalid-feedback"> {{$message}}</span>
                                            @enderror    
                                            </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="nomClient"> Nom <span style="color: red">*</span></label>
                                        <input type="text" name="nomClient" id="nomClient" class="formulaire form-control @error('nomClient') erreur @enderror" required value="{{old('nomClient')}}" onkeyup="this.value = this.value.toUpperCase();" 
                                            placeholder="Nom"><br>
                                        <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                        </div>
                                        @error('nomClient')
                                            <span class="invalid-feedback"> {{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="prenomClient"> Prénom (s)</label>
                                        <input type="text" name="prenomClient" id="prenomClient" class="formulaire form-control @error('prenomClient') erreur @enderror" value="{{old('prenomClient')}}" onkeyup="this.value = this.value.toUpperCase();" 
                                            placeholder="Prénom (s)"><br>
                                        <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                        </div>
                                        @error('prenomClient')
                                            <span class="invalid-feedback"> {{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="telephoneClient"> Téléphone <span style="color: red">*</span></label>
                                        <input type="text" name="telephoneClient" id="telephoneClient" required class="formulaire form-control @error('telephoneClient') erreur @enderror" value="{{old('telephoneClient')}}" onkeyup="this.value = this.value.toUpperCase();" 
                                            placeholder="Téléphone"><br>
                                        <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                        </div>
                                        @error('telephoneClient')
                                            <span class="invalid-feedback"> {{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="emailClient"> Email </label>
                                        <input type="email" name="emailClient" id="emailClient" class="formulaire form-control @error('emailClient') erreur @enderror" value="{{old('emailClient')}}" 
                                            placeholder="Email"><br>
                                        <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                        </div>
                                        @error('emailClient')
                                            <span class="invalid-feedback"> {{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="adresseClient"> Adresse </label>
                                        <input type="text" name="adresseClient" id="adresseClient" class="formulaire form-control @error('adresseClient') erreur @enderror" value="{{old('adresseClient')}}" onkeyup="this.value = this.value.toUpperCase();" 
                                            placeholder="Adresse"><br>
                                        <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                        </div>
                                        @error('adresseClient')
                                            <span class="invalid-feedback"> {{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0 mt-4">
                                <input type="hidden" name="rub" value="{{ $rub }}">
                                <input type="hidden" name="srub" value="{{ $srub }}">    
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" id="valider" class="btn btn-primary btnEnregistrer">{{ __('Enregistrer') }}</button>
                                    <a href="{{route('clients.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection