<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardApiController extends Controller
{
    /**
     * Mengambil data dashboard dalam format JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // dd(auth()->user());
        $user = auth()->user();

        // Pastikan user ditemukan
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
        }

        $userData = [
            'id' => $user->user_id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'role' => $user->role->role_name ?? 'Unknown',
            'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Dashboard data retrieved successfully',
            'data' => $userData,
        ]);
    }
}
