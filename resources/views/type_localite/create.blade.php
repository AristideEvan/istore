<!-- Vue create de type_localite -->
@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter type localité') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('typeLocalites.store') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="libelleTypeLocalite" class="col-md-4 col-form-label text-md-right">{{ __('Type de localité') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="libelleTypeLocalite" type="text" class="form-control @error('libelleTypeLocalite') is-invalid @enderror" name="libelleTypeLocalite"
                                    value="{{ old('libelleTypeLocalite') }}" required autofocus onkeyup="this.value = this.value.toUpperCase()" placeholder="Libelle type de localité";>
                                    <input type="hidden" name="rub" value={{$rub}} >
                                    <input type="hidden" name="srub" value={{$srub}} >
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('libelleTypeLocalite')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                    <a href="{{route('typeLocalites.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
