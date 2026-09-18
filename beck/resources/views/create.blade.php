<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            background-color: #287cb4;
            color: white;
            font-family: sans-serif;
    </style>
</head>
<body>

    <h1>CADASTRAR FILMES</h1>

    <form action="/api/filmes" method="post">
        @csrf

        <label for="" style="font-size: 20px;">titulo</label><br>
        <input type="text" name="titulo"><br>

        <label for="">diretor</label><br>
        <input type="text" name="diretor"><br>

        <label for="">ano</label><br>
        <input type="text" name="ano"><br>

        <label for="">genero</label><br>
        <input type="text" name="genero"><br>

        <label for="">sinopse</label><br>
        <input type="text" name="sinopse"><br>

        <button type="submit">salvar</button>
    </form>

</body>
</html>