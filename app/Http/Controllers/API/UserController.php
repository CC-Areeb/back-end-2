<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // show all users
    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();
        return response()->json([
            'status' => 200,
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:5',
            ]);
            $data = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => 200,
                'data' => $data
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status' => 400,
                'error' => $error->getMessage()
            ]);
        }
    }

    public function update()
    {
        try {
            if (Gate::allow('superadmin')) {
                
            }
        } catch (Exception $error) {
            return response()->json([
                'status' => 400,
                'error' => $error->getMessage()
            ]);
        }
    }
}
