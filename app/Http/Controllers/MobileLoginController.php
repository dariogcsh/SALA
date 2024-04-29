<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MobileLoginController extends Controller
{
   
    public function mobile_login(Request $request)
    {
        $stringRequest = $request->getContent();
        $jsonRequest = json_decode($stringRequest);

        $email= $jsonRequest->email;
        $password= $jsonRequest->password;
 
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = User::where('email', $email)->join('puesto_empleados', 'users.CodiPuEm', '=', 'puesto_empleados.id')->select('users.id', 'users.name', 'users.last_name', 'users.CodiPuEm', 'users.doble_check', 'puesto_empleados.NombPuEm')->get();
            $user[0]->doble_check = Str::random(128);
            $user[0]->save();
            $id = $user[0]->id;
            $role = DB::table('role_user')->where('user_id', $id)->select('role_id')->get();
            $user[0]->role = $role[0]->role_id;
            return response()->json($user[0]);
        }

        return response()->json(null);
    }
}
