<!-- Vue create pour PointVente -->
@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter un point de vente') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('pointVentes.store') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="nomPointVente"> Nom point vente <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" required onkeyup="this.value = this.value.toUpperCase();" name="nomPointVente" id="nomPointVente"
                                            placeholder="Nom point vente">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="telephonePointVente"> Téléphone <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" required onkeyup="this.value = this.value.toUpperCase();" name="telephonePointVente" id="telephonePointVente"
                                            placeholder="Téléphone">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="adressePointVente"> Adresse </label>
                                        <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="adressePointVente" id="adressePointVente"
                                            placeholder="Adresse"> <br>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="logo">Logo<span style="color: red">  ---Seuls les fichiers images sont acceptés</span></label>
                                        <input type="file"  class="form-control-file @error('logo') is-invalid @enderror" name="logo" id="logo" accept="image/*">
                                            @error('logo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                            </div>   

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="localite_id">Localité <span style="color: red">*</span></label>
                                            <select name="localite_id" class="form-control" required>
                                                <option value="">-- Sélectionner --</option>
                                                @foreach($data_localite as $items)
                                                    <option value="{{ $items->localite_id }}">{{ $items->libelleLocalite }}</option>
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
                                    <a href="{{route('pointVentes.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>

                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
