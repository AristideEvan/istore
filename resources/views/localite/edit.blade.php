<!-- Vue edit de localite -->
@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Modifier une localité') }}</div>

                <div class="card-body">
                    <form class="needs-validation" novalidate method="POST" action="{{ route('localites.update', $data->localite_id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Localité parent --}}
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="localiteParent_id">Localité parent</label>
                                <select class="form-control @error('localiteParent_id') is-invalid @enderror" name="localiteParent_id" id="localiteParent_id">
                                    <option value="">-- Sélectionner --</option>
                                    @foreach($data as $item)
                                        <option value="{{ $item->localite_id }}"
                                            {{ old('localiteParent_id', $item->localiteParent_id) == $item->localite_id ? 'selected' : '' }}>
                                            {{ $item->libelleLocalite }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('localiteParent_id')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Code localité --}}
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="codeLocalite">Code localité</label>
                                <input type="text" class="form-control @error('codeLocalite') is-invalid @enderror"
                                       onkeyup="this.value = this.value.toUpperCase();"
                                       name="codeLocalite" id="codeLocalite"
                                       value="{{ old('codeLocalite', $localite->codeLocalite) }}"
                                       placeholder="Code localité">
                                @error('codeLocalite')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Nom localité --}}
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="libelleLocalite">Nom localité <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('libelleLocalite') is-invalid @enderror"
                                       required onkeyup="this.value = this.value.toUpperCase();"
                                       name="libelleLocalite" id="libelleLocalite"
                                       value="{{ old('libelleLocalite', $localite->libelleLocalite) }}"
                                       placeholder="Nom localité">
                                @error('libelleLocalite')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Type de localité --}}
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="typeLocalite_id">Type de localité <span class="text-danger">*</span></label>
                                <select class="form-control @error('typeLocalite_id') is-invalid @enderror" name="typeLocalite_id" id="typeLocalite_id" required>
                                    <option value="">-- Sélectionner --</option>
                                    @foreach($data_typeLocalite as $item)
                                        <option value="{{ $item->typeLocalite_id }}"
                                            {{ old('typeLocalite_id', $localite->typeLocalite_id) == $item->typeLocalite_id ? 'selected' : '' }}>
                                            {{ $item->libelleTypeLocalite }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('typeLocalite_id')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <input type="hidden" name="rub" value="{{ $rub }}">
                                <input type="hidden" name="srub" value="{{ $srub }}">
                                <button type="submit" class="btn btn-primary">{{ __('Modifier') }}</button>
                                <a href="{{ route('localites.index', [$rub, $srub]) }}" class="btn btn-secondary">{{ __('Annuler') }}</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
