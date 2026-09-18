<h1>Lista de Filmes</h1>
<a href="/filmes/criar">Cadastrar Novo Filme</a>

<table border="1">
    <thead>
        <tr>
            <th>Título</th>
            <th>Diretor</th>
            <th>Ano</th>
            <th>Genero</th>
            <th>Sinopse</th>
        </tr>
    </thead>
    <tbody>
        @foreach($filmes as $filme)
            <tr>
                <td>{{ $filme->titulo }}</td>
                <td>{{ $filme->diretor }}</td>
                <td>{{ $filme->ano }}</td>
                <td>{{ $filme->genero }}</td>
                <td>{{ $filme->sinopse }}</td>
                <td><form action="/filmes/{{ $filme->id }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:none; border:none; color:red; cursor:pointer;">
                        Excluir</button></form></td>

                <td><form action="/filmes/{{ $filme->id }}/editar" method="GET" style="display:inline;">
                    @csrf
                   <button type="submit" style="background:none; border:none; color:green; cursor:pointer;">editar</button></form></td>

            </tr>
        @endforeach
    </tbody>
</table>