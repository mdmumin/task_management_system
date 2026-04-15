<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'message' => 'List of users',
            'data' => $users,
        ]);
    }
}
