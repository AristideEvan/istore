<!-- Vue index pour PointVente -->
@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub,$srub,'pointVentes.create'); @endphp
            <h4>{{ __('Liste des points de vente') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr>
                    <td>Localité</td>
                    <td>Nom point de vente</td>
                    <td>Téléphone</td>
                    <td>Adresse</td>
                     @php echo $controler->crudheader($rub,$srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $item)
                    <tr>
                        <td>{{$item->localite->libelleLocalite}}</td>
                        <td>{{$item->nomPointVente}}</td>
                        <td>{{$item->telephonePointVente}}</td>
                        <td>{{$item->adressePointVente}}</td>
                        @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'pointVentes.edit','pointVentes.destroy',$item->pointVente_id); @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
</div>
@endsection