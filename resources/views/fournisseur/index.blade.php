<!-- Vue index pour Fournisseur -->
@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub,$srub,'fournisseurs.create'); @endphp
            <h4>{{ __('Liste des fournisseurs') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr>
                    <td>Type fournisseur</td>
                    <td>Nom fournisseur</td>
                    <td>Téléphone </td>
                    <td>Adresse </td>
                    <td>Email </td>
                    <td>Numéro identifiant </td>
                     @php echo $controler->crudheader($rub,$srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $item)
                    <tr>
                        <td>{{$item->typeFournisseur->libelleTypeFournisseur}}</td>
                        <td>{{$item->nomFournisseur}}</td>
                        <td>{{$item->telephoneFournisseur}}</td>
                        <td>{{$item->adresseFournisseur}}</td>
                        <td>{{$item->emailFournisseur}}</td>
                        <td>{{$item->numeroIdentifiant}}</td>
                        @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'fournisseurs.edit','fournisseurs.destroy',$item->fournisseur_id); @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
</div>
@endsection