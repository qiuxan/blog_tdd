@extends('layouts.app')

@section('content')

    <h1 class="text-2xl font-normal mb-10 text-center">Create a Project</h1>
    <form class="" action="/projects" method="POST">
         @include('projects.form',['project'=>new App\Project])
    </form>
    {{--<form class="" action="/projects" method="POST">--}}


        {{--<h1 class="heading is-1">Create a Project</h1>--}}

        {{--<div class="field">--}}
            {{--<label for="title"class="label">--}}
                {{--Title--}}
            {{--</label>--}}

            {{--<div class="control">--}}
                {{--<input type="text" class="input" name="title" placeholder="Title">--}}
            {{--</div>--}}

        {{--</div>--}}
        {{--<div class="field">--}}
            {{--<label for="title"class="label">Description</label>--}}

            {{--<div class="control">--}}
                {{--<textarea type="text" class="textarea" name="description" placeholder="Description"></textarea>--}}
            {{--</div>--}}

        {{--</div>--}}
        {{--{{csrf_field()}}--}}

        {{--<div class="field">--}}
            {{--<div class="control">--}}
                {{--<button class="button is-link">Create Project</button>--}}
                {{--<a href="/projects">Cancel</a>--}}
            {{--</div>--}}
        {{--</div>--}}

    {{--</form>--}}
@endsection