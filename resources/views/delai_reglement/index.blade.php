<!-- Vue index pour DelaiReglement -->
@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub,$srub,'delaiReglements.create'); @endphp
            <h4>{{ __('Liste des délais de règlement') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr>
                    {{-- <th>{{__('Délai règlement')}} </th> --}}
                    <td>Nombre jours</td>
                    <td>Pénalité</td>
                    <td>Actif</td>
                     @php echo $controler->crudheader($rub,$srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $item)
                    <tr>
                        <td>{{$item->nbreJours}}</td>
                        <td>{{$item->mtPenalite}}</td>
                        <td>{{ $item->delaiActif ? 'true' : 'false' }}</td>
                        @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'delaiReglements.edit','delaiReglements.destroy',$item->delaiReglement_id); @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
</div>
@endsection