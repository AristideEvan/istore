<div class="row g-3 align-items-end pt-4" id="item_{{$key}}">
    <div class="col-md-5">
        <label for="article_id[]">Nom article <span class="text-danger">*</span></label>
        <select name="article_id[]" class="form-control" id="article_{{$key}}" required>
            <option value="">-- Sélectionner --</option>
            @foreach($data_article as $items)
                <option value="{{ $items->article_id }}">
                    {{ $items->libelleArticle }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <label for="qteRavi[]">Quantité<span class="text-danger">*</span></label>
        <input type="number" name="qteRavi[]" class="form-control" id="qteRavi_{{$key}}" required>
    </div>

    <div class="col-md-2">
        <label for="prixAchatRavi[]">PU achat</label>
        <input type="number" name="prixAchatRavi[]" class="form-control" id="prixAchat_{{$key}}">
    </div>

    <div class="col-md-2">
        <label for="modeAchat_id[]">Mode achat <span class="text-danger">*</span></label>
        <select name="modeAchat_id[]" class="form-control" id="modeAchat_{{$key}}" required>
            <option value="">-- Sélectionner --</option>
            @foreach($data_modeAchat as $items)
                <option value="{{ $items->modeAchat_id }}">
                    {{ $items->libelleModeAchat }}
                </option>
            @endforeach
        </select>
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