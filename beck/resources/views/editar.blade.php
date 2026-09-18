<form action="/filmes/{{ $filme->id }}" method="post">
    @csrf
    @method('PUT')

    <label>Título</label>
    <input type="text" name="titulo" value="{{ $filme->titulo }}"><br>

    <label>Diretor</label>
    <input type="text" name="diretor" value="{{ $filme->diretor }}"><br>

    <label>Ano</label>
    <input type="text" name="ano" value="{{ $filme->ano }}"><br>

    <label>Genero</label>
    <input type="text" name="genero" value="{{ $filme->genero }}"><br>

    <label>Sinopse</label>
    <input type="text" name="sinopse" value="{{ $filme->sinopse }}"><br>


    
    <button type="submit">Atualizar</button>
</form>