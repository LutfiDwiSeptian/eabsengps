<?php

namespace App\Http\Controllers;

use App\Models\karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data['users'] = User::query();

        if ($request->name) {
            $data['users']->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->email) {
            $data['users']->where('email', $request->email);
        }

        $data['users'] = $data['users']->paginate(10);

        return view('users.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/user/', $filename);
            $user->foto = $filename;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(Request $request)
    {
        $data['user'] = User::find($request->id);
        return view('users.edit', $data);
    }

    public function update(Request $request, $nik)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'nullable|confirmed',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $user = User::find($nik);
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->hasFile('foto')) {
                if ($user->foto && file_exists('uploads/user/' . $user->foto)) {
                    unlink('uploads/user/' . $user->foto);
                }

                $image = $request->file('foto');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = Storage::path('/public/upload/users');
                $image->move($destinationPath, $name);
                $user->foto = $name;
            }

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'User failed to update.');
        }
    }

    public function delete($nik)
    {
        $user = User::find($nik);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
