<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\user_notification;
use App\User;
use App\sucursal;
use App\Services\NotificationsService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NotificationsService $notificationsService)
    {
        $this->notificationsService = $notificationsService;
        $this->middleware('guest');
    }


     protected function showRegistrationForm(){
        $sucursals = Sucursal::where('NombSucu','<>','Otra')
                            ->orderBy('id', 'asc')->get();
        return view('auth.register', compact('sucursals'));
     }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'TeleUser' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'CodiSucu' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $usersends = User::select('users.id')
                    ->join('role_user','users.id','=','role_user.user_id')
                    ->join('roles','role_user.role_id','=','roles.id')
                    ->where([['roles.name','Admin'], ['users.TokenNotificacion','<>','']])
                    ->get();
                    
        //Envio de notificacion
        $newuser = User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'TeleUser' => $data['TeleUser'],
            'CodiSucu' => $data['CodiSucu'],
            'password' => Hash::make($data['password']),
            'TokenNotificacion' => $data['notification-token'],
        ]);

        if (isset($usersends)){
            foreach($usersends as $usersend){
                
                $notificationData = [
                    'title' => 'Sala Hnos.',
                    'body' => 'Nuevo usuario registrado',
                    'path' => '/user',
                ];
                $this->notificationsService->sendToUser($usersend->id, $notificationData);
            }
        }

        return $newuser;
    }
}
