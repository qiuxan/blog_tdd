@extends('layouts.app')

@section('content')

    <h1 class="text-2xl font-normal mb-10 text-center">Edit Your Project</h1>
    <form class="" action="{{$project->path()}}" method="POST">
        @include('projects.form')
    </form>
@endsection