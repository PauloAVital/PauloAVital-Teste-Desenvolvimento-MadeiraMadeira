@extends('admin.layouts.app')

@section('title', 'Search - Github')

@section('content')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<style>
    .linha-vertical {
        height: 12px;
        /*Altura da linha*/
        border-left: 2px solid;
        /* Adiciona borda esquerda na div como ser fosse uma linha.*/
        margin-right: 1%;
        margin-left: 1%;
    }
</style>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Busca Api GitHub
        </div>
        <div class="card-body">
            <h5 class="card-title">Busca repositorios públicos pelo nome</h5>
            <form class="form-inline" action="{{ route('home.searchUser') }}" method="GET">
                @csrf
                <div class="form-group mx-sm-3 mb-2">
                    <label for="Name" class="sr-only">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="pauloavital">
                    @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mb-2">Buscar</button>
            </form>
        </div>
        <div class="card-body">
            <h5 class="card-title">Busca repositorios públicos por Termos</h5>
            <form class="form-inline" action="{{ route('home.searchTerm') }}" method="GET">
                @csrf
                <div class="form-group mx-sm-3 mb-2">
                    <label for="Termo" class="sr-only">Termo</label>
                    <input type="text" name="termo" class="form-control" placeholder="Preencha o Campo">
                    @if ($errors->has('termo'))
                    <span class="text-danger">{{ $errors->first('termo') }}</span>
                    @endif
                </div>
                <div class="linha-vertical"></div>
                <div class="form-group mx-sm-3 mb-2">                    
                    <select class="form-control" name="language" id="language">
                        <option value="PHP">PHP</option>
                        <option value="JQUERY">JQUERY</option>
                        <option value="JAVASCRIPT">JAVASCRIPT</option>
                        <option value="HTML">HTML</option>
                        <option value="CSS">CSS</option>
                    </select>
                </div>
                <div class="linha-vertical"></div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo" id="tipo1" value="0" checked>
                    <label class="form-check-label" for="inlineRadio1">date</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo" id="tipo2" value="1">
                    <label class="form-check-label" for="inlineRadio2">star</label>
                </div>
                <div class="linha-vertical"></div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="order" id="order1" value="0" checked>
                    <label class="form-check-label" for="inlineRadio1">asc</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="order" id="order2" value="1">
                    <label class="form-check-label" for="order2">desc</label>
                </div>
                <button type="submit" class="btn btn-primary mb-2">Buscar</button>
            </form>
        </div>
    </div>

    <hr>
    <h2 class="mb-4">Busca no GitHub</h2>
    <table class="table table-hover github-datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>nome</th>
                <th>descrição</th>
                <th>language</th>
                <th>tag_url</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    var $a = jQuery.noConflict()
    $a.fn.dataTable.ext.errMode = 'throw';
    $a(function() {

        var table = $a('.github-datatable').DataTable({
            processing: true,
            serverSide: true,
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'language',
                    name: 'language'
                },
                {
                    data: 'tag_url',
                    name: 'tag_url'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });

    });
</script>


@endsection