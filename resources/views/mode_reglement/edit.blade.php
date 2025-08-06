<!-- Vue edit pour ModeReglement -->
@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Modifier mode règlement') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('modeReglements.update',$data->modeReglement_id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="libelleModeReglement" class="col-md-4 col-form-label text-md-right">{{ __('mode règlement') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="libelleModeReglement" type="text" class="form-control @error('libelleModeReglement') is-invalid @enderror" name="libelleModeReglement"
                                    value="{{ $data->libelleModeReglement }}" required autocomplete="libelleModeReglement" autofocus onkeyup="this.value = this.value.toUpperCase();">
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('libelleModeReglement')
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
                                    <a href="{{route('modeReglements.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection