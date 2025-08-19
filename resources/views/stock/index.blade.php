<!-- Vue index pour Stock -->
@extends('layouts.template')
@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0 d-flex justify-content-between align-items-center">
            {{-- @php echo $controler->newFormButton($rub,$srub,'stock.create'); @endphp --}}
            <h4 class="mb-0">{{ __('Liste du stock') }}</h4>
        </div>  
        <div class="card-body">
            <fieldset class="border p-3 mb-3 position-relative">
                <br>
                <legend class="position-absolute top-0 start-0 translate-middle-y bg-white px-2" style="font-size: 1rem;">Filtrer par magasin</legend>
                    <div class="row g-3 align-items-end pt-1">
                                    <div class="col-md-6">
                                            <form class="needs-validation d-flex w-100" novalidate method="GET" action="{{ route('stocks.index') }}">    
                                                <select name="magasin_id" id="magasin_id"  onchange="getInfoStock(this.id)" class="form-select form-select-sm">
                                                        <option value="" disabled selected>Veuillez sélectionner un magasin</option>
                                                        <option value="tout">Tout afficher</option>
                                                        @foreach($data_magasin as $items)
                                                            <option value="{{ $items->magasin_id }}" {{ request('magasin_id') == $items->magasin_id ? 'selected' : '' }}>
                                                                {{ $items->nomMagasin }}
                                                            </option>
                                                        @endforeach
                                                </select>
                                            </form> 
                                    </div>  
                    </div>                  
            </fieldset>
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover dataTable"> 
                    <thead>    
                        <tr>
                            <th>Type article</th>
                            <th>Nom article</th>
                            <th>Quantité restante</th>
                            @php echo $controler->crudheader($rub, $srub); @endphp
                        </tr>
                    </thead>
                    <tbody id="stockBody">
                        {{-- affichage des quantités restantes --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
