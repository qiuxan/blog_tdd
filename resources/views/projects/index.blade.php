@extends('layouts.app')

@section('content')

    <header class="flex items-center mb-3 py-4" >

       <div class="flex w-full items-center justify-between">
           <h2 class="text-grey text-sm font-normal">My Project</h2>
           <a class="button" href="/projects/create">New Project</a>
       </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <div class="bg-white rounded-lg shadow p-5" style="height: 200px">
                    <h3 class="text-xl font-normal py-4 -ml-5 border-l-4 border-blue-light pl-4 mb-3">
                        <a class="text-black no-underline" href="{{$project->path()}}">{{$project->title }}</a>

                    </h3>
                    <div class="text-grey">{{str_limit($project->description,100)}}</div>
                </div>
            </div>


        @empty
            <div>No project</div>

        @endforelse
    </main>



@endsection