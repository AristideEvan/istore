<!-- Vue index pour Prix -->
@extends('layouts.template')
@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0 d-flex justify-content-between align-items-center">
            {{-- @php echo $controler->newFormButton($rub,$srub,'prixes.create'); @endphp --}}
            <h4 class="mb-0">{{ __('Liste des prix') }}</h4>
        </div>  
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover dataTable"> 
                    <thead>    
                        <tr>
                            <th>Type article</th>
                            <th>Nom article</th>
                            <th>Prix unitaire vente</th>
                            @php echo $controler->crudheader($rub, $srub); @endphp
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $item)
                            <tr>
                                <td>{{ $item->typeArticle->libelleTypeArticle ?? '' }}</td>
                                <td>{{ $item->libelleArticle }}</td>
                                <td>{{ $item->prixUnitaire }}</td>
                                {{-- @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'prixes.edit','prixes.destroy'); @endphp --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
