<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('username', 'like', "%{$request->search}%");
            });
        }

        $sortColumn = $request->get('sort', 'created_at');
        $sortDirection = $request->get('dir', 'desc');

        $allowedColumns = ['name', 'username', 'role', 'created_at'];

        if (in_array($sortColumn, $allowedColumns)) {
            $query->orderBy($sortColumn, $sortDirection);
        } else {
            $query->latest();
        }

        $users = $query->paginate(100)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|alpha_dash|max:25|unique:user',
            'password' => 'required|string|min:3',
            'role'     => 'required|in:admin,user',
        ]);

        User::create([
            'name'     => Str::title($request->name),
            'username' => Str::lower($request->username),
            'password' => $request->password,
            // 'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        if ($request->wantsJson()) return response()->json(['status' => 'success']);
        return back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => ['required', 'alpha_dash', Rule::unique('user')->ignore($user->id)],
            'role'     => 'required|in:admin,user',
        ]);

        $data = [
            'name'     => Str::title($request->name),
            'username' => Str::lower($request->username),
            'role'     => $request->role,
        ];

        // if ($request->filled('password')) {
        //     $request->validate(['password' => 'min:3']);
        //     $data['password'] = Hash::make($request->password);
        // }

        $user->update($data);

        if ($request->wantsJson()) return response()->json(['status' => 'success']);
        return back()->with('success', 'Data user diperbarui.');
    }

    public function destroy(User $user)
    {
        // Cegah menghapus diri sendiri
        if ($user->id === Auth::id()) {
            return response()->json(['message' => 'Anda tidak bisa menghapus akun sendiri.'], 403);
        }

        $user->delete();

        return response()->json(['status' => 'success']);
    }
}
