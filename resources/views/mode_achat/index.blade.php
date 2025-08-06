<!-- Vue index pour ModeAchat -->
@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub,$srub,'modeAchats.create'); @endphp
            <h4>{{ __('Liste des modes achat') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr>
                    <th>{{__('Mode achat')}} </th>
                     @php echo $controler->crudheader($rub,$srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $item)
                    <tr>
                        <td>{{$item->libelleModeAchat}}</td>
                        @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'modeAchats.edit','modeAchats.destroy',$item->modeAchat_id); @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
</div>
@endsection