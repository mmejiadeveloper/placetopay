<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Publicaicones</h1>

        <div class="panel panel-default">
            <div class="panel-header">
                {{ $post->title }}
            </div>
            <div class="panel-body">
                {{ $post->body }}
            </div>
            <a href="/">Regresar</a>
        </div>
    </div>
</body>
</html>