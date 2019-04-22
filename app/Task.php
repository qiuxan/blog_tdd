<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded=[];

    protected $casts=[
        'completed'=>'boolean'
        ];

    protected $touches=['project'];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::created(function ($task){

            $task->project->recordActivity('created_task');
//            Activity::create([
//                'project_id'=>$task->project->id,
//                'description'=>'created_task'
//            ]);
        });

      
    }

    public function complete()
    {
        $this->update(['completed'=>true]);

        $this->project->recordActivity('completed_task');
    }
    public function project(){

        return $this->belongsTo(Project::class);
    }

    public function path(){
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }
}
