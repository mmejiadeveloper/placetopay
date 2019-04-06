<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Blog</title>
    
</head>
<body>
    <div class="container">
        <h1>Publicaicones</h1>
        @foreach ($posts as $post)
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="/posts/{{ $post->id }}"> {{ $post->title }}</a>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>