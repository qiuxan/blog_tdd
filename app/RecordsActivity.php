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
}