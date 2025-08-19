<!-- Vue index pour VenteComptantCredit -->
@extends('layouts.template')
@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub,$srub,'venteComptantCredits.create'); @endphp
            <h4>{{ __('Liste des ventes') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr>
                    <td>Date </td>
                    <td>Type vente</td>
                    <td>Type client</td>
                    <td>Nom client</td>
                    <td>Montant total </td>
                    <td>Montant remise </td>
                    <td>Montant TVA </td>
                    <td>Montant net </td>
                     @php echo $controler->crudheader($rub,$srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $item)
                @php
                    $nom= $item->ligneVente_client->nomClient.' '.$item->ligneVente_client->prenomClient;
                @endphp
                    <tr>
                        <td>{{$item->ligneVente_vente->dateVente}}</td>
                        <td>{{$item->ligneVente_typeVente->libelleTypeVente ?? ''}}</td>
                        <td>{{$item->ligneVente_client->typeClient->libelleTypeClient ?? '' }}</td>
                        <td>{{$nom}}</td>
                        <td>{{$item->ligneVente_vente->mtTotalVente ?? ''}}</td>
                        <td>{{$item->ligneVente_vente->mtRemiseVente ?? ''}}</td>
                        <td>{{$item->ligneVente_vente->mtTvaVente ?? ''}}</td>
                        <td>{{$item->ligneVente_vente->mtNetVente ?? ''}}</td>
                        @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'venteComptantCredits.edit','venteComptantCredits.destroy',$item->vente_id); @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
</div>
@endsection