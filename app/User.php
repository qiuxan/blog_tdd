<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function projects()
    {

        return $this->hasMany(Project::class,'owner_id')->orderByDesc('updated_at');

    }

    public function accseeibleProjects(){
//        $projectCreated= $this->projects;
//
//        $ids=\DB::table('project_members')->where('user_id',$this->id)->pluck('project_id');
//
//        $projectsSharedWith=Project::find($ids);
//
//        return $projectCreated->merge($projectsSharedWith);

        return Project::where('owner_id', $this->id)
            ->orWhereHas('members', function ($query) {
                $query->where('user_id', $this->id);
            })
            ->get();
    }


}
