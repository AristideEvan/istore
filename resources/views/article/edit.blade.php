<!-- Vue edit pour Article -->
@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Modifier article') }}</div>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="POST" action="{{ route('articles.update', $data->article_id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="typeArticle_id">Type article <span style="color: red">*</span></label>
                                    <select name="typeArticle_id" class="form-control" required><br>
                                        <option value="">-- Sélectionner --</option>
                                        @foreach($data_typeArticle as $items)
                                            <option value="{{ $items->typeArticle_id }}" {{ $data->typeArticle_id == $items->typeArticle_id ? 'selected' : '' }}>
                                                {{ $items->libelleTypeArticle }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="libelleArticle">Article <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" required onkeyup="this.value = this.value.toUpperCase();" name="libelleArticle" id="libelleArticle"
                                           value="{{ old('libelleArticle', $data->libelleArticle) }}" placeholder="Article"><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="descriptionArticle">Description</label>
                                    <textarea rows="4" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="descriptionArticle" id="descriptionArticle"
                                              placeholder="Description">{{ old('descriptionArticle', $data->descriptionArticle) }}</textarea><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="uniteMesure">Unité mesure</label>
                                    <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="uniteMesure" id="uniteMesure"
                                           value="{{ old('uniteMesure', $data->uniteMesure) }}" placeholder="Unité mesure"><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="couleur">Couleur</label>
                                    <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="couleur" id="couleur"
                                           value="{{ old('couleur', $data->couleur) }}" placeholder="Couleur"><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="poids">Poids</label>
                                    <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="poids" id="poids"
                                           value="{{ old('poids', $data->poids) }}" placeholder="Poids"><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="poids">Stock alerte</label>
                                    <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="stockAlerte" id="stockAlerte"
                                           value="{{ old('stockAlerte', $data->stockAlerte) }}" placeholder="Stock alerte"><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="datePeremption">Date péremption</label>
                                    <input type="date" class="form-control" name="datePeremption" id="datePeremption"
                                           value="{{ old('datePeremption', $data->datePeremption) }}" placeholder="Date péremption"><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0 mt-4">
                            <input type="hidden" name="rub" value="{{ $rub }}">
                            <input type="hidden" name="srub" value="{{ $srub }}">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                    <a href="{{route('articles.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
