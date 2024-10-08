<?php

namespace App\Http\Controllers;

use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index($userId)
    {
        $data['user'] = User::findOrFail($userId);
        return view('backend.user.profile', $data);
    }

    public function showList()
    {
        $users = User::all();
        return view('backend.user.userList', compact('users'));
    }

    public function create(Request $request)
    {
        $preUrl = $request->query('preUrl', '/');
        return view('backend.auth.signup', ['preUrl' => $preUrl]);
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'mobile' => 'required|string|max:15',
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'bio' => 'nullable|string',
                'location' => 'nullable|string|max:255',
                'function' => 'nullable|string|max:255',
            ]);


            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->mobile = $request->mobile;
            $user->bio = $request->bio;
            $user->location = $request->location;
            $user->function = $request->function;

            if ($request->hasFile('img')) {
                $user->img = $request->file('img')->store('images', 'public');
            }

            $user->save();


            Toastr::success('Successfully signed up. Please log in.', 'Signed up!', ["positionClass" => "toast-top-center"]);
            return redirect()->route('login', ['preUrl' => $request->input('preUrl')]);
        } catch (\Exception $e) {
            Toastr::error('An error occurred: ' . $e->getMessage(), 'Sign up failed!', ["positionClass" => "toast-top-center"]);
            return redirect()->back();
        }
    }


    public function edit($id)
    {
        $data['types'] = [1 => 'Super Admin', 2 => 'Admin', 3 => 'Customer'];
        $data['user'] = User::findOrFail($id);
        return view('backend.user.updateUser', $data);
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:users,email,' . $request->id,
                'mobile' => 'nullable|string|max:20',
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'bio' => 'nullable|string',
                'location' => 'nullable|string|max:255',
                'function' => 'nullable|string|max:255',
                'type' => 'nullable|integer|',
                'old_password' => 'nullable|string|min:6',
                'password' => 'nullable|string|min:6|confirmed',
            ]);

            $user = User::findOrFail($request->id);

            // Check if the old password is provided and is correct
            if ($request->filled('old_password')) {
                if (!Hash::check($request->old_password, $user->password)) {
                    throw ValidationException::withMessages([
                        'old_password' => 'The provided password does not match your current password.',
                    ]);
                }

                // If old password is correct and new password is provided, update the password
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }
            }

            $user->name = $request->name ?? $user->name;
            $user->email = $request->email ?? $user->email;
            $user->mobile = $request->mobile ?? $user->mobile;
            $user->bio = $request->bio ?? $user->bio;
            $user->location = $request->location ?? $user->location;
            $user->function = $request->function ?? $user->function;
            $user->type = $request->type ?? $user->type;

            if ($request->hasFile('img')) {
                // delete prev img
                if ($user->img) Storage::disk('public')->delete($user->img);
                // save new img
                $user->img = $request->file('img')->store('images', 'public');
            }

            $user->save();

            Toastr::success($user->name . ' has been updated', 'Updated successfully!', ["positionClass" => "toast-top-center"]);

            return redirect()->back()->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);

            // Delete the image if it exists
            if ($user->img) {
                Storage::disk('public')->delete($user->img);
            }

            // Delete the product from the database
            $user->delete();

            if (Auth::id() == $id)
                return redirect()->route('logout')->with('success', 'User deleted successfully.');

            return redirect()->back()->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
