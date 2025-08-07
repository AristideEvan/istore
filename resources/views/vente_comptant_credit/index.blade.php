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
                    <td>Type vente</td>
                    <td>Type client</td>
                    <td>Date </td>
                    <td>Montant total </td>
                    <td>Montant remise </td>
                    <td>Montant TVA </td>
                    <td>Montant net </td>
                     @php echo $controler->crudheader($rub,$srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $item)
                    <tr>
                        <td>{{$item->dateVente}}</td>
                        
                        @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'venteComptantCredits.edit','venteComptantCredits.destroy',$item->ravi_id); @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
</div>
@endsection