<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',

    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')
            ->withPivot('role')
            ->withTimestamps();
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * تسک‌هایی که کاربر ساخته (owner)
     */
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'creator_id');
    }

    /**
     * تسک‌هایی که به کاربر Assign شده
     */
    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
