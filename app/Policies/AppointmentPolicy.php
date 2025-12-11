<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Appointment $appointment)
    {
        if ($user->hasRole('Admin')) return true;
        if ($user->hasRole('Doctor') && $appointment->doctor_id === $user->id) return true;
        if ($user->hasRole('Patient') && $appointment->patient_id === $user->id) return true;
        return $user->hasPermissionTo('view appointments');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create appointments');
    }

    public function update(User $user, Appointment $appointment)
    {
        if ($user->hasRole('Admin')) return true;
        if ($user->hasRole('Doctor') && $appointment->doctor_id === $user->id) return true;
        return $user->hasPermissionTo('edit appointments');
    }

    public function delete(User $user, Appointment $appointment)
    {
        if ($user->hasRole('Admin')) return true;
        if ($user->hasRole('Doctor') && $appointment->doctor_id === $user->id) return true;
        return $user->hasPermissionTo('cancel appointments');
    }

    public function complete(User $user, Appointment $appointment)
    {
        if ($user->hasRole('Admin')) return true;
        if ($user->hasRole('Doctor') && $appointment->doctor_id === $user->id) return true;
        return $user->hasPermissionTo('complete appointments');
    }

    public function cancel(User $user, Appointment $appointment)
    {
        if ($user->hasRole('Admin')) return true;
        if ($user->hasRole('Doctor') && $appointment->doctor_id === $user->id) return true;
        return $user->hasPermissionTo('cancel appointments');
    }
}
