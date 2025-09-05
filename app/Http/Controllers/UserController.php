<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validateUser = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $existingUser = User::where('email', $validateUser['email'])->exists();
        if (!$existingUser) {
            $newUser = new User();
            $newUser->name = $validateUser['name'];
            $newUser->email = $validateUser['email'];
            $newUser->password = Hash::make($validateUser['password']);

            $newUser->save();

            return response()->json([
                "success" => true,
                "status" => 200,
                "message" => "User Registered Successfully!",
                "data" => $newUser,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "status" => 400,
                "message" => "User Already Exists!",
            ]);
        }
    }

    public function login(Request $request)
    {
        $validateRequest = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $checkUser = User::where('email', $validateRequest['email'])->get()->first();
        if ($checkUser) {
            if ($checkUser['status'] == 'active') {
                if (Hash::check($validateRequest['password'], $checkUser['password'])) {
                    $token = $checkUser->createToken('userToken')->accessToken;
                    return response()->json([
                        "success" => true,
                        "status" => 200,
                        "message" => "Login Successful!",
                        "data" => $checkUser,
                        "token" => $token,
                    ]);
                } else {
                    return response()->json([
                        "success" => false,
                        "status" => 400,
                        "message" => "Incorrect Password!"
                    ]);
                }
            } else {
                return response()->json([
                    "success" => false,
                    "status" => 400,
                    "message" => "Account has been blocked!"
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "status" => 404,
                "message" => "Email not found!"
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
