<div class="card" style="height: 200px">
    <h3 class="text-xl font-normal py-4 -ml-5 border-l-4 border-blue-light pl-4 mb-3">
        <a class="text-black no-underline" href="{{$project->path()}}">{{$project->title }}</a>
    </h3>
    <div class="text-grey">{{str_limit($project->description,100)}}</div>
</div>
