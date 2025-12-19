<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Specialist;

class SpecialistHoursUpdatedNotification extends Notification
{
    use Queueable;

    protected $specialist;
    protected $updatedBy;

    public function __construct(Specialist $specialist, $updatedBy = 'System')
    {
        $this->specialist = $specialist;
        $this->updatedBy = $updatedBy;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'specialist_id' => $this->specialist->id,
            'specialist_name' => $this->specialist->name,
            'message' => "Working hours updated for {$this->specialist->name} by {$this->updatedBy}",
            'updated_by' => $this->updatedBy,
        ];
    }
}