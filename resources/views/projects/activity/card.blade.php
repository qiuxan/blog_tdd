<div class="card mt-3" >
    @foreach($project->activity as $activity)
        <ul class="text-xs list-reset">

            <li class="{{$loop->last?'':'mb-1'}}">

                @include("projects.activity.{$activity->description}")
                <span class="text-grey">
                    {{$activity->created_at->diffForHumans(null,true)}}
                </span>

            </li>
        </ul>
    @endforeach
</div>