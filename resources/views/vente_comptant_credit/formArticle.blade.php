
    <div class="row g-3 align-items-end pt-4" id="item_{{$key}}">
        {{-- Bloc articles --}}
        <div class="col-md-2">
            <label for="typeArticle_id[]">{{ __('Type article')}} <span style="color: red">*</span></label>
                <select name="typeArticle_id[]" id="typeArticle_{{$key}}" class="form-control" onchange="getArticleByType('article_id[]',this.id,'{{$key}}')" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($data_typeArticle as $items)
                        <option value="{{ $items->typeArticle_id }}">
                            {{ $items->libelleTypeArticle }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    {{__('formulaire.Obligation')}}
                </div>
                @error('typeArticle_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>
        <div class="col-md-3">
            <label for="article_id[]">{{ __('Nom article')}} <span style="color: red">*</span></label>
                <select name="article_id[]" class="form-control" id="article_{{$key}}" onchange="getInfoQte(this.id,'{{$key}}')" required>
                    <option value="">-- Sélectionner --</option>
                       {{-- liste des articles --}}
                </select>
                <div class="invalid-feedback">
                    {{__('formulaire.Obligation')}}
                </div>
                @error('article_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>
        <div class="col-md-1">
            <label for="qteRestant">{{ __('Qte rest')}}</label>
            <input type="number" id="qteRestant_{{$key}}" name="qteRestant[]" class="form-control">
            <div class="invalid-feedback">
                {{__('formulaire.Obligation')}}
            </div>
            @error('qteRestant')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror   
        </div>
        <div class="col-md-2">
            <label for="prixVente">{{ __('PU Vente')}}</label>
            <input type="number" id="prixVente_{{$key}}" name="prixVente[]" class="form-control" onchange="getMontantByQtePU(this.id,'{{$key}}')">
        </div>
        <div class="col-md-1">
            <label for="qteVente">{{ __('Qte Sor')}}<span style="color: red">*</span></label>
            <input type="number" id="qteVente_{{$key}}" name="qteVente[]" class="form-control" onchange="getMontantByQtePU(this.id,'{{$key}}')">
            <div class="invalid-feedback">
                {{__('formulaire.Obligation')}}
            </div>
            @error('qteVente')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror   
        </div>
        <div class="col-md-2">
            <label for="mtHtVente">{{ __('Montant total')}}</label>
            <input type="mtHtVente" id="mtHtVente_{{$key}}" name="mtHtVente[]" readonly class="form-control">
            <div class="invalid-feedback">
                {{__('formulaire.Obligation')}}
            </div>
            @error('mtHtVente')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror   
        </div>

        <div class="col-md-1">
            <a href="#" class="btn btn-danger" onclick="removeElem('item_{{$key}}')"><i class="fas fa-trash"></i></a>
        </div>
    </div>
    
<script>
    jQuery('select').select2({
        language: "fr",
        width: '100%'
    });
</script>
