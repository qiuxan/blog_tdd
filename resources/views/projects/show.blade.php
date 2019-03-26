@extends('layouts.app')
@section('content')
        <header class="flex items-center mb-3 py-4" >
           <div class="flex w-full items-end justify-between">
               <p class="text-grey text-sm font-normal">
                   <a class="text-grey text-sm font-normal no-underline" href="/projects">My Projects </a> /{{$project->title}}
               </p>
               <a class="button" href="/projects/create">New Project</a>
           </div>
        </header>
        <main>
            <div class="lg:flex -mx-3">
                <div class="lg:w-3/4 px-3 mb-6">
                    <div class="mb-8">
                        <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>
                        @foreach($project->tasks as $task)
                            <div class="card mb-3">
                                <form action="{{$task->path()}}" method="POST">
                                    @method('PATCH')
                                    {{csrf_field()}}
                                    <div class="flex">
                                        <input type="text" class="w-full {{$task->completed? 'text-grey':''}}" name="body" value="{{$task->body}}">
                                        <input type="checkbox" name="completed" onchange="this.form.submit()" {{$task->completed?'checked':''}}>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                        {{--tasks--}}
                         <div class="card mb-3">
                            <form action="{{$project->path().'/tasks'}}" method="POST">
                                {{csrf_field()}}
                                <input name="body" class="w-full" type="text" placeholder="Add a new task">
                            </form>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
                        {{--general notes--}}
                        <textarea class="card w-full" style="min-height:200px">/dafasdsn dasfayys</textarea>
                    </div>
                </div>
                <div class="lg:w-1/4 px-3">
                    @include('projects.card')
                </div>
            </div>
        </main>

@endsection