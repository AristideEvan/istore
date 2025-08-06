<!-- Vue create pour TypeVente -->
@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter type vente') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('typeVentes.store') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="libelleTypeVente" class="col-md-4 col-form-label text-md-right">{{ __('Type vente') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="libelleTypeVente" type="text" class="form-control @error('libelleTypeVente') is-invalid @enderror" name="libelleTypeVente"
                                    value="{{ old('libelleTypeVente') }}" required autofocus onkeyup="this.value = this.value.toUpperCase()" placeholder="Type vente";>
                                    <input type="hidden" name="rub" value={{$rub}} >
                                    <input type="hidden" name="srub" value={{$srub}} >
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('libelleTypeVente')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                    <a href="{{route('typeVentes.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection