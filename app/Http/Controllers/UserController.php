<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // $credentials = $request->only('email', 'password');
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (!Auth::attempt($credentials)) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials'], 500);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => 'Admin',
            ],
            'token' =>  $token,
        ]);

        // if (Auth::attempt($credentials)) {
                            

        //     $request->session()->regenerate();
        //     $user = Auth::user();
        //     // session([
        //     //     'user_id' => $user->id,
        //     //     'user_name' => $user->name,
        //     //     'user_email' => $user->email,
        //     //     'user_role' => $user->role,
        //     //     'modal_shown' => 1,

        //     // ]);
        //         // Redirect to the intended page or home
        //         return response()->json(['message' => 'Login successful']);
        // }
    }

    public function RegisterForm(Request $request){

    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $usermail = DB::table('users')->where('email', $request->email)->first();

        if ($usermail) {
            return redirect()->back()->with('error', 'This email is already registered.');
        }

    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $userId = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => null,
        ]);
    
        $user = DB::table('users')->find($userId);
        
        return response()->json(['message' => 'User resgister successful']);    
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return response()->json(['message' => 'Logout successful']);
    }
}
