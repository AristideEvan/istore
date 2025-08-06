<!-- Vue index pour Ravitaillement -->
@extends('layouts.template')
@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub,$srub,'ravitaillements.create'); @endphp
            <h4>{{ __('Liste des stocks') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr>
                    <td>Date</td>
                    <td>Nom fournisseur</td>
                    <td>Nom magasin </td>
                    <td>Nom article </td>
                    <td>Quantité </td>
                    <td>PU achat </td>
                    <td>Mode achat </td>
                     @php echo $controler->crudheader($rub,$srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $item)
                    <tr>
                        <td>{{$item->dateRavi}}</td>
                        <td>{{$item->fournisseur->nomFournisseur}}</td>
                        <td>{{$item->magasin->nomMagasin}}</td>
                        <td>{{$item->article->libelleArticle}}</td>
                        <td>{{$item->qteRavi}}</td>
                        <td>{{$item->prixAchatRavi}}</td>
                        <td>{{$item->modeAchat->libelleModeAchat}}</td>
                        @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'ravitaillements.edit','ravitaillements.destroy',$item->ravi_id); @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
</div>
@endsection