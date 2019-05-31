@extends('layouts.app')
@section('content')
        <header class="flex items-center mb-3 py-4" >
           <div class="flex w-full items-end justify-between">
               <p class="text-default text-sm font-normal">
                   <a class="text-default text-sm font-normal no-underline" href="/projects">My Projects </a> /{{$project->title}}
               </p>

               <div class="flex items-center">
                   @foreach ($project->members as $member)
                       <img
                               src="{{ gravatar_url($member->email) }}"
                               alt="{{ $member->name }}'s avatar"
                               class="rounded-full w-8 mr-2">
                   @endforeach

                   <img
                           src="{{ gravatar_url($project->owner->email) }}"
                           alt="{{ $project->owner->name }}'s avatar"
                           class="rounded-full w-8 mr-2">

                   <a href="{{ $project->path().'/edit' }}" class="button ml-4">Edit Project</a>
               </div>
           </div>
        </header>
        <main>
            <div class="lg:flex -mx-3">
                <div class="lg:w-3/4 px-3 mb-6">
                    <div class="mb-8">
                        <h2 class="text-lg text-default font-normal mb-3">Tasks</h2>
                        @foreach($project->tasks as $task)
                            <div class="card mb-3">
                                <form action="{{$task->path()}}" method="POST">
                                    @method('PATCH')
                                    {{csrf_field()}}
                                    <div class="flex">
                                        <input type="text" class="bg-card text-default w-full {{$task->completed? 'text-default':''}}" name="body" value="{{$task->body}}">
                                        <input type="checkbox" name="completed" onchange="this.form.submit()" {{$task->completed?'checked':''}}>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                        {{--tasks--}}
                         <div class="card mb-3">
                            <form action="{{$project->path().'/tasks'}}" method="POST">
                                {{csrf_field()}}
                                <input name="body" class="bg-card text-default w-full" type="text" placeholder="Add a new task">
                            </form>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-lg text-default font-normal mb-3">General Notes</h2>
                        {{--general notes--}}
                        <form action="{{$project->path()}}" method="POST">
                            {{csrf_field()}}
                            <textarea
                                    class="card w-full"
                                    style="min-height:200px"
                                    placeholder="Anything Special you want"
                                    name="notes"
                            >{{$project->notes}}</textarea>
                            <button type="submit" class="button">Save</button>
                            @method('PATCH')
                        </form>

                        @include ('errors')


                    </div>
                </div>
                <div class="lg:w-1/4 px-3">
                    @include('projects.card')
                    @include('projects.activity.card')
                    @can('manage',$project)
                        @include('projects.invite')
                    @endcan




                </div>


            </div>
        </main>

@endsection