<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.css">
</head>
<body>
    <form class="container" action="/projects" method="POST" style="padding-top: 40px">


        <h1 class="heading is-1">Create a Project</h1>

        <div class="field">
            <label for="title"class="label">
                Title
            </label>

            <div class="control">
                <input type="text" class="input" name="" placeholder="Title">
            </div>

        </div>
        <div class="field">
            <label for="title"class="label">Description</label>

            <div class="control">
                <textarea type="text" class="textarea"></textarea>
            </div>

        </div>
        {{csrf_field()}}

        <div class="field">
            <div class="control">
                <button class="button is-link">Create Project</button>
            </div>
        </div>

    </form>
</body>
</html>