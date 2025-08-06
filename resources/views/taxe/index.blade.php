<!-- Vue index pour Taxe -->
@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub,$srub,'taxes.create'); @endphp
            <h4>{{ __('Liste des taxes') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr>
                    <th>{{__('Taxe')}} </th>
                     @php echo $controler->crudheader($rub,$srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $item)
                    <tr>
                        <td>{{$item->tauxTva}}</td>
                        @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'taxes.edit','taxes.destroy',$item->taxe_id); @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
</div>
@endsection