<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'description',
        'user_id',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function getTimeSpent(User $user): int
    {

        $diff = 0;

        foreach ($this->tasks as $key => $task) {
            $diff += $task->getTimeSpent($user);
        }

        return $diff;
    }
}
