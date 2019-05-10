@if (count($activity->changes['after'])==1)
    You updated the {{key($activity->changes['after'])}}
@else
    You updated the project
@endif


