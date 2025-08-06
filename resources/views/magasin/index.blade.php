<!-- Vue index pour Magasin -->
@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub,$srub,'magasins.create'); @endphp
            <h4>{{ __('Liste des magasins') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr>
                    <td>Nom magasin</td>
                    <td>Capacité</td>
                     @php echo $controler->crudheader($rub,$srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $item)
                    <tr>
                        <td>{{$item->nomMagasin}}</td>
                        <td>{{$item->capacite}}</td>
                        @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'magasins.edit','magasins.destroy',$item->magasin_id); @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
</div>
@endsection