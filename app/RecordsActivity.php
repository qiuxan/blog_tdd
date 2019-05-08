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

        foreach (self::recordableEvens() as $event){
            static::$event(function ($model) use ($event){

                $model->recordActivity($model->activityDescription($event));
            });

            if ($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }

        }
    }

    protected function activityDescription($description){

        return "{$description}_".strtolower(class_basename($this));//created_task

    }
    /**
     * @return array
     */
    public static function recordableEvens(): array
    {
        if (isset(static::$recordableEvens)) {
            return static::$recordableEvens;
        }
            return ['created', 'updated', 'deleted'];
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