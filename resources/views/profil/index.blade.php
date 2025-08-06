@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header py-0">
        @php echo $controler->newFormButton($rub,$srub,'profil.create'); @endphp
        <h5>{{ __('Liste des profils') }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                {{ csrf_field() }}
                <table id="example" class="table dataTable" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>{{ __('Profil') }}</th>
                            @php echo $controler->crudheader($rub,$srub); @endphp
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas  as $profil)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $profil->nomProfil }}</td>
                                @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'profil.edit','profil.destroy',$profil->profil_id); @endphp
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection