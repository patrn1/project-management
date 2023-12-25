<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'description',
        'user_id',
        'project_id',
        'assignee_id',
        'timer_started_at',
        'timer_stopped_at',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Возвращает время, затраченное пользователем на задачу
     */
    public function getTimeSpent(User $user): int
    {

        $diff = 0;

        if ($this->assignee?->id === $user->id) {
            if ($this->timer_started_at) {
                $diff = now()->getTimeStampMs() - $this->getTimerStartedAt()?->getTimeStampMs();
            }
        }

        return $diff;
    }

    /**
     * Возвращает время старта таймера
     *
     * @return Carbon
     */
    public function getTimerStartedAt()
    {
        return Carbon::parse($this->timer_started_at);
    }

    /**
     * Возвращает время остановки таймера
     *
     * @return Carbon
     */
    public function getTimerStoppedAt()
    {
        return Carbon::parse($this->timer_stopped_at);
    }
}
