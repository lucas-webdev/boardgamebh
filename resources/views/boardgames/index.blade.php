@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb mb-3">
        <div class="pull-left">
            <h2>Planilha de jogos </h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('boardgames.create') }}" title="Adicionar jogo">
                <i class="fas fa-plus-circle"></i>
                Adicionar jogo
            </a>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<table class="table table-bordered table-responsive-xs table-striped bg-list">
    <tr>
        <th class="name" style="width: 40%">Jogo</th>
        <th class="negociation" style="width: 20%">Negociação</th>
        <th class="price" style="width: 10%">Preço</th>
        <th class="condition" style="width: 20%">Condição</th>
        <th></th>
    </tr>

    @foreach ($boardgames as $boardgame)
    <tr>
        <td>{{ $boardgame->name }} </td>
        <td>{{ $boardgame->negociation }} </td>
        <td>{{ $boardgame->price }} </td>
        <td>{{ $boardgame->condition }} </td>
        <td>
            <?php
            $formattedNumber = preg_replace('/[- )(]/', '', $boardgame->owner_contact);
            ?>
            <button type="button" class="btn btn-lg btn-info" data-toggle="popover" data-placement="left" data-trigger="focus" title="{{ $boardgame->name }}" data-html="true" data-content="
                Edição: {{ $boardgame->edition }} <br>
                Idioma: {{ $boardgame->language }} <br>
                Depend. Idioma: {{ $boardgame->language_dependency }} <br>
                Descrição: {{ $boardgame->language_description }} <br>
                Responsável: {{ $boardgame->owner }} <br>
                Contato: <a target='_blank' href='https://wa.me/{{$formattedNumber}}/'>{{ $boardgame->owner_contact }}</a><br>
                Wishlist: {{ $boardgame->owner_wishlist }} <br>
                ">
                Mais detalhes
            </button>

        </td>

        <!-- <td>
            <form action="{{ route('boardgames.destroy', $boardgame->id) }}" method="POST">

                <a href="{{ route('boardgames.show', $boardgame->id) }}" title="show">
                    <i class="fas fa-eye text-success  fa-lg"></i>
                </a>

                <a href="{{ route('boardgames.edit', $boardgame->id) }}">
                    <i class="fas fa-edit  fa-lg"></i>

                </a>

                @csrf
                @method('DELETE')

                <button type="submit" title="delete" style="border: none; background-color:transparent;">
                    <i class="fas fa-trash fa-lg text-danger"></i>

                </button>
            </form>
        </td> -->
    </tr>
    @endforeach
</table>

<div class="modal-body">

</div>

@endsection
