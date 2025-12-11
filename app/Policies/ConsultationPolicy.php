<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Consultation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsultationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Consultation $consultation)
    {
        if ($user->hasRole('Admin')) return true;
        if ($user->hasRole('Doctor') && $consultation->appointment->doctor_id === $user->id) return true;
        return $user->hasPermissionTo('view consultations');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create consultations');
    }

    public function update(User $user, Consultation $consultation)
    {
        if ($user->hasRole('Admin')) return true;
        if ($user->hasRole('Doctor') && $consultation->appointment->doctor_id === $user->id) return true;
        return $user->hasPermissionTo('edit consultations');
    }
}
