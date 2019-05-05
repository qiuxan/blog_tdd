<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordsActivity;

    protected $guarded =[];
    public $old=[];
    public function path(){

        return "/projects/{$this->id}";

    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
       return $this->tasks()->create(compact('body'));

    }
    public function activity(){
        return $this->hasMany(Activity::class)->latest();
    }

    protected function activityChanges()
    {
        if ($this->wasChanged())
        {
            return [
                'before'=>array_except(array_diff($this->old,$this->toArray()),'updated_at'),
                'after'=>array_except($this->getChanges(),'updated_at'),
            ];
        }
    }
}
