<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewAppointmentNotification extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Appointment Scheduled')
            ->line('A new appointment has been scheduled.')
            ->line('Patient: ' . $this->appointment->patient->name)
            ->line('Time: ' . $this->appointment->appointment_time->format('M d, Y h:i A'))
            ->action('View Appointment', url('/appointments/' . $this->appointment->id));
    }

    public function toArray($notifiable)
    {
        return [
            'appointment_id' => $this->appointment->id,
            'patient_name' => $this->appointment->patient->name,
            'appointment_time' => $this->appointment->appointment_time,
            'message' => 'New appointment scheduled with ' . $this->appointment->patient->name,
        ];
    }
}
