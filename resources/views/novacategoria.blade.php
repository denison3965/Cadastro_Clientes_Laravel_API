@extends('layouts.app', ["current" => "categorias"])

@section('body')
    <h4>Nova categoria</h4>

    <form action="/categorias" method="POST">
        @csrf
        <div class="form-group mt-3">
            <label for="nomeCategoria ">Nome da Categoria</label>
            <input id="nomeCategoria" class="form-control" name="nomeCategoria" 
                type="text" placeholder="Categoria">
        </div>
        <button type="submit" class="btn btn-primary btn-sm mt-3">Salvar</button>
        <button type="submit" class="btn btn-danger btn-sm mt-3">Deletar</button>
    </form>
@endsection