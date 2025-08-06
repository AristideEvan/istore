<!-- Vue edit pour Magasin -->
@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Modifier magasin') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('magasins.update',$data->magasin_id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                
                                <label for="nomMagasin" class="col-md-4 col-form-label text-md-right">{{ __('magasin') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="nomMagasin" type="text" class="form-control @error('nomMagasin') is-invalid @enderror" name="nomMagasin"
                                    value="{{ $data->nomMagasin }}" required autocomplete="nomMagasin" autofocus onkeyup="this.value = this.value.toUpperCase();">
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('nomMagasin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <label for="capacite" class="col-md-4 col-form-label text-md-right">{{ __('Capacité') }}</span></label>
                                <div class="col-md-6">
                                    <input id="capacite" type="text" class="form-control @error('capacite') is-invalid @enderror" name="capacite"
                                    value="{{ $data->capacite }}" required autocomplete="capacite" autofocus onkeyup="this.value = this.value.toUpperCase();">
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('capacite')
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
                                    <a href="{{route('magasins.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection