<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <h1>Birdboard</h1>
    <ul>
        @foreach($projects as $project)

            <li>{{$project->title}}</li>
        @endforeach
    </ul>
</body>
</html>