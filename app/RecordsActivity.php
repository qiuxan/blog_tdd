<?php
/**
 * Created by PhpStorm.
 * User: xianqiu
 * Date: 6/5/19
 * Time: 12:19 AM
 */

namespace App;


trait RecordsActivity
{

    public $oldAttributes=[];

    public static function bootRecordsActivity(){

        static::updating(function ($model){
            $model->oldAttributes=$model->getOriginal();

        });


        if (isset(static::$recordableEvens)){
            $recordableEvens=static::$recordableEvens;
        }else{
            $recordableEvens=['created','updated','deleted'];

        }


        foreach ($recordableEvens as $event){
            static::$event(function ($model) use ($event){
                if(class_basename($model)!=='Project'){
                    $event="{$event}_".strtolower(class_basename($model));//created_task

                    //dd($event);
                }
                $model->recordActivity($event);


            });
        }
    }

    public function recordActivity($description)
    {
//        var_dump(
//
//            array_diff($this->toArray(),$this->old)
//
//        );
        $this->activity()->create([
            'description' => $description,

            'changes' => $this->activityChanges(),

            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id
        ]);
    }

    public function activity(){
        return $this->morphMany(Activity::class,'subject')->latest();
    }

    protected function activityChanges()
    {
        if ($this->wasChanged())
        {
            return [
                'before' => array_except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after'=>array_except($this->getChanges(),'updated_at'),
            ];
        }
    }
}