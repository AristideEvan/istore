<!-- Vue index pour TypeFournisseur -->
@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub,$srub,'typeFournisseurs.create'); @endphp
            <h4>{{ __('Liste des types de fournisseur') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr>
                    <th>{{__('Type fournisseur')}} </th>
                     @php echo $controler->crudheader($rub,$srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $item)
                    <tr>
                        <td>{{$item->libelleTypeFournisseur}}</td>
                        @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'typeFournisseurs.edit','typeFournisseurs.destroy',$item->typeFournisseur_id); @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
</div>
@endsection