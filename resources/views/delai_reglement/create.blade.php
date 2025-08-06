<!-- Vue create pour DelaiReglement -->
@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter mode règlement') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('delaiReglements.store') }}">
                            @csrf
                            <div class="form-group row">
                                
                                <label for="nbreJours" class="col-md-4 col-form-label text-md-right">{{ __('Nombre jours') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="nbreJours" type="number" class="form-control @error('nbreJours') is-invalid @enderror" name="nbreJours"
                                    value="{{ old('nbreJours') }}" placeholder="Nombre jours";>
                                    {{-- <input type="hidden" name="rub" value={{$rub}} >
                                    <input type="hidden" name="srub" value={{$srub}} > --}}
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('nbreJours')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <label for="mtPenalite" class="col-md-4 col-form-label text-md-right">{{ __('Montant pénalité') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="mtPenalite" type="number" class="form-control @error('mtPenalite') is-invalid @enderror" name="mtPenalite"
                                    value="{{ old('mtPenalite') }}" placeholder="Montant pénalité";>
                                    {{-- <input type="hidden" name="rub" value={{$rub}} >
                                    <input type="hidden" name="srub" value={{$srub}} > --}}
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('mtPenalite')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <label for="delaiActif" class="col-md-4 col-form-label text-md-right">{{ __('Actif') }}</label>
                                <div class="col-md-6">
                                    <input id="delaiActif" type="checkbox" class="form-control @error('delaiActif') is-invalid @enderror" name="delaiActif"
                                    value="1" {{ old('delaiActif') }} checked>
                                    {{-- <input type="hidden" name="rub" value={{$rub}} >
                                    <input type="hidden" name="srub" value={{$srub}} > --}}
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('delaiActif')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group row mb-0">
                            <input type="hidden" name="rub" value={{$rub}} >
                            <input type="hidden" name="srub" value={{$srub}} >    
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                    <a href="{{route('delaiReglements.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection