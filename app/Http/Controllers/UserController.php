<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(20);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'status' => 'required|in:active,deactivated',
            'nid' => 'nullable|string|max:30|unique:users',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'district' => 'nullable|string|max:100',
            'upazila' => 'nullable|string|max:100',
            // Doctor specific fields
            'bmdc_registration' => 'nullable|string|max:50|unique:users',
            'specialization' => 'nullable|string|max:100',
            'consultation_fee' => 'nullable|numeric|min:0',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'nid' => $request->nid,
            'date_of_birth' => $request->date_of_birth,
            'blood_group' => $request->blood_group,
            'district' => $request->district,
            'upazila' => $request->upazila,
            'bmdc_registration' => $request->bmdc_registration,
            'specialization' => $request->specialization,
            'consultation_fee' => $request->consultation_fee,
            'qualifications' => $request->qualifications,
            'experience' => $request->experience,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'village' => $request->village,
            'post_office' => $request->post_office,
            'post_code' => $request->post_code,
            'marital_status' => $request->marital_status,
            'religion' => $request->religion,
            'emergency_contact' => $request->emergency_contact,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $user->load('roles');
        $roles = Role::all();
        $currentRole = $user->roles->first()->name ?? null;

        return view('admin.users.edit', compact('user', 'roles', 'currentRole'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|exists:roles,name',
            'status' => 'required|in:active,deactivated',
            'nid' => ['nullable', 'string', 'max:30', Rule::unique('users')->ignore($user->id)],
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'district' => 'nullable|string|max:100',
            'upazila' => 'nullable|string|max:100',
            // Doctor specific fields
            'bmdc_registration' => ['nullable', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'specialization' => 'nullable|string|max:100',
            'consultation_fee' => 'nullable|numeric|min:0',
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'nid' => $request->nid,
            'date_of_birth' => $request->date_of_birth,
            'blood_group' => $request->blood_group,
            'district' => $request->district,
            'upazila' => $request->upazila,
            'bmdc_registration' => $request->bmdc_registration,
            'specialization' => $request->specialization,
            'consultation_fee' => $request->consultation_fee,
            'qualifications' => $request->qualifications,
            'experience' => $request->experience,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'village' => $request->village,
            'post_office' => $request->post_office,
            'post_code' => $request->post_code,
            'marital_status' => $request->marital_status,
            'religion' => $request->religion,
            'emergency_contact' => $request->emergency_contact,
        ]);

        // Update role
        $currentRole = $user->roles->first();
        if ($currentRole && $currentRole->name !== $request->role) {
            $user->removeRole($currentRole->name);
            $user->assignRole($request->role);
        } elseif (!$currentRole) {
            $user->assignRole($request->role);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user status.
     */
    public function toggleStatus(User $user)
    {
        // Prevent deactivating yourself
        if ($user->id === Auth::id() && $user->status === 'active') {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot deactivate your own account.');
        }

        $user->status = $user->status === 'active' ? 'deactivated' : 'active';
        $user->save();

        $action = $user->status === 'active' ? 'activated' : 'deactivated';
        return redirect()->route('admin.users.index')
            ->with('success', "User {$action} successfully.");
    }
}
