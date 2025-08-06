<!-- Vue edit pour PointVente -->
@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Modifier point vente') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('pointVentes.update',$data->pointVente_id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="nomPointVente" class="col-md-4 col-form-label text-md-right">{{ __('Nom point de vente') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="nomPointVente" type="text" class="form-control @error('nomPointVente') is-invalid @enderror" name="nomPointVente"
                                    value="{{ $data->nomPointVente }}" required autocomplete="nomPointVente" autofocus onkeyup="this.value = this.value.toUpperCase();">
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('nomPointVente')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>   
                            </div>

                            <div class="form-group row">
                                <label for="telephonePointVente" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="telephonePointVente" type="text" class="form-control @error('telephonePointVente') is-invalid @enderror" name="telephonePointVente"
                                    value="{{ $data->telephonePointVente }}" required autocomplete="telephonePointVente" autofocus onkeyup="this.value = this.value.toUpperCase();">
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('telephonePointVente')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>   
                            </div>

                            <div class="form-group row">
                                <label for="adressePointVente" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone') }}</label>
                                <div class="col-md-6">
                                    <input id="adressePointVente" type="text" class="form-control @error('telephonePointVente') is-invalid @enderror" name="adressePointVente"
                                    value="{{ $data->adressePointVente }}" required autocomplete="adressePointVente" autofocus onkeyup="this.value = this.value.toUpperCase();">
                                </div>   
                            </div>

                            <div class="form-group row">
                                <label for="localite_id" class="col-md-4 col-form-label text-md-right">{{ __('Localité') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">  
                                    <select name="localite_id" required>
                                        <option value="">-- Sélectionner --</option>
                                        @foreach($data_localite as $items)
                                            <option value="{{ $items->localite_id }}" {{ $data->localite_id == $items->localite_id ? 'selected' : '' }}>
                                                {{ $items->libelleLocalite }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 

                            <input type="hidden" name="rub" value={{$rub}} >
                            <input type="hidden" name="srub" value={{$srub}}>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
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