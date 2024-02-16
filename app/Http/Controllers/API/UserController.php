<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // show all users
    public function index()
    {
        if (Gate::allows('superadmin')) {
            try {
                $users = User::orderBy('id', 'asc')->get();
                return response()->json([
                    'status' => 200,
                    'users' => $users->getUserDisplayFields()
                ]);
            } catch (Exception $error) {
                return response()->json([
                    'status' => 400,
                    'error' => $error->getMessage(),
                ], 400);
            }
        }
    }

    public function singleUser($id)
    {
        if (Gate::allows('superadmin')) {
            try {
                $user = User::findorFail($id);
                return response()->json([
                    'status' => 200,
                    'user' => $user->getUserDisplayFields()
                ]);
            } catch (Exception $error) {
                return response()->json([
                    'status'=> 400,
                    'error'=> $error->getMessage(),
                ], 400);
            }
        }
    }
    public function store(Request $request)
    {
        if (Gate::allow('superadmin')) {
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
    }

    public function update(Request $request, $id)
    {
        try {
            if (Gate::allows('superadmin')) {
                $user = User::findOrFail($id);
                $data = $user->update([
                    'name' => $request->name,
                    'account_status' => $request->account_status
                ]);
                return response()->json([
                    'status' => 200,
                    'data' => $data
                ]);
            }
        } catch (Exception $error) {
            return response()->json([
                'status' => 400,
                'error' => $error->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        if (Gate::allows('superadmin')) {
            try {
                $user = User::findOrFail($id);
                $user->delete();
                return response()->json([
                    'status' => 200,
                    'message' => "User account has been deleted successfully",
                ]);
            } catch (Exception $error) {
                return response()->json([
                    "status" => 400,
                    "error" => $error->getMessage()
                ]);
            }
        }
    }
}
