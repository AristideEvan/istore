<!-- Vue index pour Article -->
@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub,$srub,'articles.create'); @endphp
            <h4>{{ __('Liste des articles') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr>
                    <td>Type article</td>
                    <td>Nom article </td>
                    <td>Description </td>
                    <td>Unité mesure </td>
                    <td>couleur </td>
                    <td>Poids </td>
                    <td>Date péremption </td>
                     @php echo $controler->crudheader($rub,$srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $item)
                    <tr>
                        <td>{{$item->typeArticle->libelleTypeArticle}}</td>
                        <td>{{$item->libelleArticle}}</td>
                        <td>{{$item->descriptionArticle}}</td>
                        <td>{{$item->uniteMesure}}</td>
                        <td>{{$item->couleur}}</td>
                        <td>{{$item->poids}}</td>
                        <td>{{$item->datePeremption}}</td>
                        @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'articles.edit','articles.destroy',$item->article_id); @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
</div>
@endsection