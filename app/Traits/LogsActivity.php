<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        foreach (['created', 'updated', 'deleted'] as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    protected function recordActivity($event)
    {
        $description = $this->getActivityDescription($event);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $event,
            'description' => $description,
            'subject_type' => get_class($this),
            'subject_id' => $this->id,
            'properties' => json_encode($this->getOriginal()), // Simplification: Log original state
        ]);
    }

    protected function getActivityDescription($event)
    {
        $modelName = class_basename($this);
        $action = ucfirst($event); // Created, Updated, Deleted

        // Try to find a recognizable name
        $name = $this->name ?? $this->title ?? $this->name_item ?? 'ID ' . $this->id;

        return "$action $modelName: $name";
    }
}
