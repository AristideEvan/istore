<!-- Vue create pour Article -->
@extends('layouts.template')
@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter article') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('articles.store') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="typeArticle_id">Type article <span style="color: red">*</span></label>
                                            <select name="typeArticle_id" class="form-control" required><br>
                                                <option value="">-- Sélectionner --</option>
                                                @foreach($data_typeArticle as $items)
                                                    <option value="{{ $items->typeArticle_id }}">{{ $items->libelleTypeArticle }}</option>
                                                @endforeach
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('typeArticle_id')
                                                <span class="invalid-feedback"> {{$message}}</span>
                                            @enderror    
                                            </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="libelleArticle"> Article <span style="color: red">*</span></label>
                                        <input type="text" name="libelleArticle" id="libelleArticle" class="formulaire form-control @error('libelleArticle') erreur @enderror"  required required value="{{old('libelleArticle')}}" onkeyup="this.value = this.value.toUpperCase();" 
                                            placeholder="Article"><br>
                                        <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                        </div>
                                        @error('libelleArticle')
                                            <span class="invalid-feedback"> {{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="descriptionArticle"> Description </label>
                                        <textarea type="text" rows="4" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="descriptionArticle" id="descriptionArticle"
                                            placeholder="Description"></textarea><br>
                                         <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                        </div>
                                        @error('descriptionArticle')
                                            <span class="invalid-feedback"> {{$message}}</span>
                                        @enderror   
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="uniteMesure"> Unité mesure </label>
                                        <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="uniteMesure" id="uniteMesure"
                                            placeholder="Unité mesure"> <br>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="couleur"> Couleur </label>
                                        <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="couleur" id="couleur"
                                            placeholder="Couleur"> <br>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="poids"> Poids </label>
                                        <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="poids" id="poids"
                                            placeholder="Poids"> <br>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="stockAlerte"> Stock alerte </label>
                                        <input type="number" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="stockAlerte" id="stockAlerte"
                                            placeholder="Stock alerte"> <br>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="datePeremption"> Date péremption </label>
                                        <input type="date" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="datePeremption" id="datePeremption"
                                            placeholder="Date péremption"> <br>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0 mt-4">
                                <input type="hidden" name="rub" value="{{ $rub }}">
                                <input type="hidden" name="srub" value="{{ $srub }}">    
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" id="valider" class="btn btn-primary btnEnregistrer">{{ __('Enregistrer') }}</button>
                                    <a href="{{route('articles.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

