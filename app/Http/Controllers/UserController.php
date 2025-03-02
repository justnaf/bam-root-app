<?php

namespace App\Http\Controllers;

use App\Models\DataDiri;
use App\Models\ModelRequestRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roleCounts = [
            'Super Admin' => User::role('SuperAdmin')->count(),
            'Admin' => User::role('Admin')->count(),
            'Instruktur' => User::role('Instruktur')->count(),
            'Peserta' => User::role('Peserta')->count(),
        ];

        $users = User::with(['roles', 'dataDiri'])->get();

        return view('accounts.index', compact('users', 'roleCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('modelHistoryEvent.event');
        return view('accounts.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('accounts.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($user->save()) {
            if ($user->roles()->sync($request->role)) {
                return redirect()->route('users.index')->with('success', 'User updated successfully and Role Changed.');
            } else {
                return redirect()->route('users.index')->with('warning', 'User updated successfully, Role Not Changed.');
            }
        } else {
            return redirect()->route('users.index')->with('error', 'User updated failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User Deleted successfully.');
    }

    public function pendingSubmission()
    {
        $pendings = ModelRequestRole::with(['user.dataDiri', 'user.roles'])->where('status', 'pending')->get();

        return view('accounts.submission.request', compact('pendings'));
    }

    public function showSubmission(ModelRequestRole $pendings)
    {
        return view('accounts.submission.show', compact('pendings'));
    }

    public function approveSubmission(User $userId, ModelRequestRole $id)
    {
        $idRole = Role::where('name', $id->requested_role)->get('id');
        $changeRole = $userId->roles()->sync($idRole);
        if ($changeRole) {
            $id->status = 'approved';
            if ($id->save()) {
                return redirect()->route('submission.role.pending')->with('success', 'Aprrove Pengajuan Role Sukses');
            } else {
                return redirect()->route('submission.role.pending')->with('error', 'Gagal Mengganti Status');
            }
        } else {

            return redirect()->route('submission.role.pending')->with('warning', 'Role Tidak Ditemukan');
        }
    }

    public function declineSubmission(User $userId, ModelRequestRole $id)
    {
        $id->status = 'declined';
        if ($id->save()) {
            return redirect()->route('submission.role.pending')->with('error', 'Pengajuan Role Di Tolak');
        } else {
            return redirect()->route('submission.role.pending')->with('error', 'Gagal Mengganti Status');
        }
    }

    public function indexSubmission()
    {
        $alls = ModelRequestRole::with(['user.dataDiri', 'user.roles'])->get();

        return view('accounts.submission.index', compact('alls'));
    }
}
