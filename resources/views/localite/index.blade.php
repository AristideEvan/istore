<!-- Vue index de localite -->

@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header py-0">
                @php echo $controler->newFormButton($rub,$srub,'localites.create'); @endphp
                <h5>{{ __('Liste des localités') }}</h5>
            </div>
        <div class="card-body table-responsive">
            <table id="example" class="table table-hover dataTable">
                <thead >
                    <tr>
                        <th>Code</th>
                        <th>Parent</th>
                        <th>Nom Localité</th>
                        <th>Type localité</th>
                        @php echo $controler->crudheader($rub,$srub); @endphp
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas as $data)
                        <tr>
                            <td>{{ $data->codeLocalite }}</td>
                            <td>{{ $data->parentLocalite?->libelleLocalite }}</td>
                            <td>{{ $data->libelleLocalite }}</td>
                            <td>{{ $data->typeLocalite->libelleTypeLocalite }}</td>
                            @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'localites.edit','localites.destroy',$data->localite_id); @endphp
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <br>
</div>
@endsection
