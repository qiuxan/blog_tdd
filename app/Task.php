<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordsActivity;
    protected $guarded=[];

    protected $casts=[
        'completed'=>'boolean'
        ];

    protected $touches=['project'];



    public function complete()
    {
        $this->update(['completed'=>true]);

        $this->recordActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update(['completed'=>false]);
        $this->recordActivity('incompleted_task');
    }
    public function project(){

        return $this->belongsTo(Project::class);
    }

    public function path(){
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function activity(){
        return $this->morphMany(Activity::class,'subject')->latest();
    }

    protected function activityChanges()
    {
        return null;

        if ($this->wasChanged())
        {
            return [
                'before'=>array_except(array_diff($this->old,$this->toArray()),'updated_at'),
                'after'=>array_except($this->getChanges(),'updated_at'),
            ];
        }
    }


}
