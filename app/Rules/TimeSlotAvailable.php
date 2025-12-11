<?php

namespace App\Rules;

use App\Models\Appointment;
use Illuminate\Contracts\Validation\Rule;

class TimeSlotAvailable implements Rule
{
    protected $doctorId;
    protected $appointmentId;

    public function __construct($doctorId, $appointmentId = null)
    {
        $this->doctorId = $doctorId;
        $this->appointmentId = $appointmentId;
    }

    public function passes($attribute, $value)
    {
        $query = Appointment::where('doctor_id', $this->doctorId)
            ->where('appointment_time', $value)
            ->where('status', 'scheduled');

        if ($this->appointmentId) {
            $query->where('id', '!=', $this->appointmentId);
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'This time slot is already booked. Please choose another time.';
    }
}
