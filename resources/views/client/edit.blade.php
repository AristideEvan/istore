<!-- Vue edit pour Client -->
@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Modifier client') }}</div>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="POST" action="{{ route('clients.update', $data->client_id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="typeClient_id">Type client </label>
                                    <select name="typeClient_id" class="form-control">
                                        <option value="">-- Sélectionner --</option>
                                        @foreach($data_typeClient as $items)
                                            <option value="{{ $items->typeClient_id }}" {{ $data->typeClient_id == $items->typeClient_id ? 'selected' : '' }}>
                                            {{ $items->libelleTypeClient }} 
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="numeroCompte">Numéro compte </label>
                                    <input type="text" class="form-control" name="numeroCompte" id="numeroCompte"
                                           value="{{ old('numeroCompte', $data->numeroCompte) }}"disabled placeholder="Numéro compte"><br>
                                    <input type="hidden" name="numeroCompte" value="client->numeroCompte }}">       
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="nomClient">Nom <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" required onkeyup="this.value = this.value.toUpperCase();" name="nomClient" id="nomClient"
                                           value="{{ old('nomClient', $data->nomClient) }}" placeholder="Nom"><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="prenomClient">Prénom (s)</label>
                                    <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="prenomClient" id="prenomClient"
                                           value="{{ old('prenomClient', $data->prenomClient) }}" placeholder="Prénom (s)"><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="telephoneClient">Téléphone</label>
                                    <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="telephoneClient" id="telephoneClient"
                                           value="{{ old('telephoneClient', $data->telephoneClient) }}" placeholder="téléphone"><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="emailClient">Email</label>
                                    <input type="text" class="form-control" name="emailClient" id="emailClient"
                                           value="{{ old('emailClient', $data->emailClient) }}" placeholder="Email"><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group">
                                    <label for="adresseClient">Adresse</label>
                                    <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="adresseClient" id="adresseClient"
                                           value="{{ old('adresseClient', $data->adresseClient) }}" placeholder="Adresse"><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0 mt-4">
                            <input type="hidden" name="rub" value="{{ $rub }}">
                            <input type="hidden" name="srub" value="{{ $srub }}">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                    <a href="{{route('clients.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
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