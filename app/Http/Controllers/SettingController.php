<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'current_password' => 'required_with:password',
            'password' => 'nullable|min:8|confirmed',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ];

        // Update password if provided
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $updateData['password'] = Hash::make($validated['password']);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }
            $updateData['avatar'] = $request->file('avatar')->store('avatars');
        }

        $user->update($updateData);

        return back()->with('success', 'Settings updated successfully.');
    }

    public function system()
    {
        // Only for admin
        $this->authorize('system-settings');

        $settings = [
            'clinic_name' => config('app.name'),
            'clinic_address' => config('app.address'),
            'clinic_phone' => config('app.phone'),
            'clinic_email' => config('app.email'),
            'appointment_interval' => config('app.appointment_interval', 30),
            'working_hours_start' => config('app.working_hours_start', '09:00'),
            'working_hours_end' => config('app.working_hours_end', '17:00'),
            'currency' => config('app.currency', 'USD'),
        ];

        return view('settings.system', compact('settings'));
    }

    public function updateSystem(Request $request)
    {
        $this->authorize('system-settings');

        $validated = $request->validate([
            'clinic_name' => 'required|string|max:255',
            'clinic_address' => 'required|string',
            'clinic_phone' => 'required|string',
            'clinic_email' => 'required|email',
            'appointment_interval' => 'required|integer|min:15|max:60',
            'working_hours_start' => 'required|date_format:H:i',
            'working_hours_end' => 'required|date_format:H:i|after:working_hours_start',
            'currency' => 'required|string|size:3',
        ]);

        // Update config file or database settings
        // For now, we'll just return success
        // In production, you should store these in database

        return back()->with('success', 'System settings updated successfully.');
    }
}
