<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;



class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(20);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $user = new User(); // empty model for form
        return view('users.form', [
            'user' => $user,
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z\'\- ]+$/'],
            'last_name' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[A-Za-z\'\- ]+$/'
            ],
            'name' => ['required','string','max:255','regex:/^[A-Za-z\'\- ]+$/'],
            'email'            => ['required', 'email', 'max:255', 'unique:users,email,'],
            'username' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9._]+$/',
                'unique:users,username,',
            ],
            'password' => [
                            'nullable',
                            Password::min(8)
                                ->letters()
                                ->numbers()
                                ->symbols(),
                        ],
            'status'           => ['required', 'in:active,inactive'],
            'role'             => ['required', 'in:admin,manager,collector,biller'],
            'designation' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9\'\- ]+$/'
            ],
            'employee_id' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9\-]+$/'
            ],
            'pseudo_first_name' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[A-Za-z\'\- ]+$/'
            ],
            'pseudo_last_name' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[A-Za-z\'\- ]+$/'
            ],
            'phone'              => ['nullable', 'regex:/^\(\d{3}\)\s\d{3}-\d{4}$/'],
            'dob'              => ['nullable', 'date'],
            'profile_picture'  => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'signature'        => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            ],
            [
                'first_name.regex' => 'First name may only contain letters.',
                'last_name.regex'          => 'Last name may only contain letters, spaces, hyphens, and apostrophes.',
                'phone.regex' => 'Phone number must be in the format (999) 999-9999.',
                'name.regex'               => 'Name may only contain letters and spaces.',
                'username.regex'           => 'Username may only contain letters, numbers, dots, and underscores.',
                'designation.regex'        => 'Designation may only contain letters and numbers.',
                'employee_id.regex'        => 'Employee ID may only contain letters, numbers, and hyphens.',
                'pseudo_first_name.regex'  => 'Pseudo first name may only contain letters.',
                'pseudo_last_name.regex'   => 'Pseudo last name may only contain letters.',
            ]
        );

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.form', [
            'user' => $user,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, User $user)
    {
        $originalStatus = $user->status;

        // 2) Admin updating any user → full update
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z\'\- ]+$/'],
            'last_name' => ['nullable','string','max:50','regex:/^[A-Za-z\'\- ]+$/'],
            'name' => ['required','string','max:255','regex:/^[A-Za-z\'\- ]+$/'],
            'email'            => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'username' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9._]+$/',
                'unique:users,username,' . $user->id
            ],
            'password' => [
                            'nullable',
                            Password::min(8)
                                ->letters()
                                ->numbers()
                                ->symbols(),
                        ],
            'status'           => ['required', 'in:active,inactive'],
            'role'             => ['required', 'in:admin,manager,collector,biller'],
            'designation' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9\'\- ]+$/'
            ],
            'employee_id' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9\-]+$/'
            ],
            'pseudo_first_name' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[A-Za-z\'\- ]+$/'
            ],
            'pseudo_last_name' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[A-Za-z\'\- ]+$/'
            ],
            'phone'              => ['nullable', 'regex:/^\(\d{3}\)\s\d{3}-\d{4}$/'],
            'dob'              => ['nullable', 'date'],
            'profile_picture'  => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'signature'        => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            ],
            [
                'first_name.regex' => 'First name may only contain letters.',
                'last_name.regex'          => 'Last name may only contain letters, spaces, hyphens, and apostrophes.',
                'phone.regex' => 'Phone number must be in the format (999) 999-9999.',
                'name.regex'               => 'Name may only contain letters and spaces.',
                'username.regex'           => 'Username may only contain letters, numbers, dots, and underscores.',
                'designation.regex'        => 'Designation may only contain letters and numbers.',
                'employee_id.regex'        => 'Employee ID may only contain letters, numbers, and hyphens.',
                'pseudo_first_name.regex'  => 'Pseudo first name may only contain letters.',
                'pseudo_last_name.regex'   => 'Pseudo last name may only contain letters.',
            ]
        );

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $data['profile_picture_path'] = $path;
        }

        if ($request->hasFile('signature')) {
            $path = $request->file('signature')->store('signatures', 'public');
            $data['signature_path'] = $path;
        }

        $statusChanged = array_key_exists('status', $data)
        && $data['status'] !== $originalStatus;
        // password handling:

        if ($statusChanged && empty($request->password)) {
            // Force admin to enter a new password
            throw \Illuminate\Validation\ValidationException::withMessages([
                'password' => ['You must set a new password when changing account status.'],
            ]);
        }
        if (!empty($data['password'])) {
            // admin manually set a new password
            $data['password'] = Hash::make($data['password']);
        } elseif ($statusChanged) {
            // status changed -> auto-generate a new password
            $newPasswordPlain = Str::random(10); // or whatever length you want
            $data['password'] = Hash::make($newPasswordPlain);

            // optional: show it once to admin
            // return redirect()->route('users.index')
            //     ->with('success', 'User updated. New password: '.$newPasswordPlain);
        } else {
            // no manual password and no status change -> keep old password
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
    public function profile()
    {
        $user = Auth::user();

        return view('users.profile', [
            'user' => $user,
        ]);
    }
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'password' => [
                'nullable',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
            'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'signature'       => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture_path = $path;
        }

        if ($request->hasFile('signature')) {
            $path = $request->file('signature')->store('signatures', 'public');
            $user->signature_path = $path;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }


    public function forceLogout(User $user)
    {
        $user->session_version = (int) $user->session_version + 1;
        $user->force_logout_version = (int) $user->force_logout_version + 1;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User has been forced to log out.');
    }

    public function destroy(User $user)
    {

        if ($user->role === 'admin') {
            return redirect()
                ->back()
                ->with('error', 'Admin accounts cannot be deleted.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function trash()
    {
        $users = User::onlyTrashed()->orderBy('id', 'desc')->paginate(20);

        return view('users.trash', compact('users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.trash')->with('success', 'User restored successfully.');
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('users.trash')->with('success', 'User permanently deleted.');
    }
}
