<!-- Vue create de localite -->
@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter une localité') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('localites.store') }}">
                            @csrf
                             <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="localiteParent_id">Localité parent</label><br>
                                            <select name="localiteParent_id">
                                                <option value="">-- Sélectionner --</option>
                                                @foreach($data_localite as $localite)
                                                    <option value="{{ $localite->localite_id }}">{{ $localite->libelleLocalite }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="codeLocalite">Code localité </label>
                                        <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="codeLocalite" id="codeLocalite"
                                            placeholder="code localité">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="libelleLocalite"> Nom localité <span style="color: red">*</span></label>
                                        <input type="text" required class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="libelleLocalite" id="libelleLocalite"
                                            placeholder="nom localité">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="typeLocalite_id">Type de localité <span style="color: red">*</span></label><br>
                                            <select name="typeLocalite_id" required>
                                                <option value="">-- Sélectionner --</option>
                                                @foreach($data_typeLocalite as $items)
                                                    <option value="{{ $items->typeLocalite_id }}">{{ $items->libelleTypeLocalite }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="hidden" name="rub" value={{$rub}} >
                                    <input type="hidden" name="srub" value={{$srub}} >
                                    <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                    <a href="{{route('localites.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>

                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
