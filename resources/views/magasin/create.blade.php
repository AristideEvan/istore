<!-- Vue create pour Magasin -->
@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter magasin') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('magasins.store') }}">
                            @csrf
                            <div class="form-group row">
                                
                                <label for="nomMagasin" class="col-md-4 col-form-label text-md-right">{{ __('Magasin') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="nomMagasin" type="text" class="form-control @error('nomMagasin') is-invalid @enderror" name="nomMagasin"
                                    value="{{ old('nomMagasin') }}" required autofocus onkeyup="this.value = this.value.toUpperCase()" placeholder="Magasin";>
                                    <input type="hidden" name="rub" value={{$rub}} >
                                    <input type="hidden" name="srub" value={{$srub}} >
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('nomMagasin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <label for="capacite" class="col-md-4 col-form-label text-md-right">{{ __('Capacité') }}</label>
                                <div class="col-md-6">
                                    <input id="capacite" type="text" class="form-control @error('capacite') is-invalid @enderror" name="capacite"
                                    value="{{ old('capacite') }}" required autofocus onkeyup="this.value = this.value.toUpperCase()" placeholder="Capacité";>
                                    <input type="hidden" name="rub" value={{$rub}} >
                                    <input type="hidden" name="srub" value={{$srub}} >
                                    {{-- <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('capacite')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror --}}
                                </div>


                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                    <a href="{{route('modeAchats.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection