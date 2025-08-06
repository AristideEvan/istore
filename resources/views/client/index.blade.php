<!-- Vue index pour Client -->
@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub,$srub,'clients.create'); @endphp
            <h4>{{ __('Liste des clients') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr>
                    <td>Type client</td>
                    <td>Numero compte client </td>
                    <td>Nom </td>
                    <td>Prénom (s) </td>
                    <td>Téléphone </td>
                    <td>Email </td>
                    <td>Adresse </td>
                     @php echo $controler->crudheader($rub,$srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $item)
                    <tr>
                        <td>{{$item->typeClient->libelleTypeClient }}</td>
                        <td>{{$item->numeroCompte}}</td>
                        <td>{{$item->nomClient}}</td>
                        <td>{{$item->prenomClient}}</td>
                        <td>{{$item->telephoneClient}}</td>
                        <td>{{$item->emailClient }}</td>
                        <td>{{$item->adresseClient}}</td>
                        @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'clients.edit','clients.destroy',$item->client_id); @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
</div>
@endsection