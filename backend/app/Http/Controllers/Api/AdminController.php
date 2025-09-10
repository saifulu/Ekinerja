<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function getUsers()
    {
        $users = User::select('id', 'name', 'email', 'role', 'phone', 'nip', 'golongan', 'instansi', 'ruangan', 'created_at')
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return response()->json($users);
    }

    public function getStats()
    {
        try {
            Log::info('AdminController::getStats called by user: ' . auth()->id());
            
            $totalUsers = User::count();
            $totalAdmins = User::where('role', 'admin')->count();
            $activeUsers = User::whereNotNull('email_verified_at')->count();
            
            $stats = [
                'success' => true,
                'total_users' => $totalUsers,
                'total_admins' => $totalAdmins,
                'active_users' => $activeUsers
            ];
            
            Log::info('Stats generated successfully', $stats);
            
            return response()->json($stats)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
                
        } catch (\Exception $e) {
            Log::error('Error in getStats: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving stats',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
    
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
            'phone' => 'nullable|string|max:20',
            'nip' => 'nullable|string|max:50',
            'golongan' => 'nullable|string|max:100',
            'instansi' => 'nullable|string|max:255',
            'ruangan' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'nip' => $request->nip,
            'golongan' => $request->golongan,
            'instansi' => $request->instansi,
            'ruangan' => $request->ruangan
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }
    
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,user',
            'phone' => 'nullable|string|max:20',
            'nip' => 'nullable|string|max:50',
            'golongan' => 'nullable|string|max:100',
            'instansi' => 'nullable|string|max:255',
            'ruangan' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'nip' => $request->nip,
            'golongan' => $request->golongan,
            'instansi' => $request->instansi,
            'ruangan' => $request->ruangan
        ]);
        
        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }
    
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting the last admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete the last admin user'
            ], 422);
        }
        
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}