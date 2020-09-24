@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Adicionar jogo</h2>
        </div>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Ops!</strong> Tivemos problemas em adicionar o seu jogo.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{ route('boardgames.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="form-group">
                <label>Nome do jogo:</label>
                <input type="text" name="name" class="form-control">
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Negociação:</label>
                <select class="form-control" name="negociation">
                    <option value="Troca e Venda">Troca e venda</option>
                    <option value="Troca">Troca</option>
                    <option value="Venda">Venda</option>
                </select>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Preço:</label>
                <input type="text" name="price" class="form-control" aria-describedby="priceHelp">
                <small id="priceHelp" class="form-text text-muted">Obrigatório para venda.</small>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Condição:</label>
                <select class="form-control" name="condition">
                    <option value="Lacrado">Lacrado</option>
                    <option value="Ótimo estado (como novo)">Ótimo estado (como novo)</option>
                    <option value="Bom estado">Bom estado</option>
                    <option value="Avariado">Avariado</option>
                </select>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Edição / Editora:</label>
                <input type="text" name="edition" class="form-control">
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Idioma do jogo:</label>
                <input type="text" name="language" class="form-control">
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Depend. de Idioma:</label>
                <select class="form-control" name="condition">
                    <option value="Não depende">Jogo em pt-br</option>
                    <option value="Alta dependência">Alta dependência</option>
                    <option value="Media dependência">Media dependência</option>
                    <option value="Pouca dependência">Pouca dependência</option>
                    <option value="Não depende">Sem dependência</option>
                </select>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Descrição:</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Responsável:</label>
                <input type="text" name="owner" class="form-control">
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Contato:</label>
                <input type="text" name="owner_contact" class="form-control" placeholder="(XX) XXXXX-XXXX">
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="form-group">
                <label>Link wishlist:</label>
                <input type="text" name="wishlist" class="form-control">
            </div>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </div>

</form>
@endsection
