<?php

namespace App\Http\Controllers\Auth;

use App\Enums\VendeurStatus;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/client/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return User
     */
    protected function create(array $data)
    {
        $clientRole = Role::firstOrCreate(['nom_role' => 'client']);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role_id' => $clientRole->id,
        ]);

        $user->load('role');

        try {
            $user->syncProfileByRole();
        } catch (\Throwable) {
            // Le profil peut être créé plus tard si la migration n'est pas encore passée.
        }

        return $user;
    }

    protected function redirectTo(): string
    {
        $user = $this->guard()->user();

        if ($user?->hasRole('admin')) {
            return route('admin.dashboard');
        }

        if ($user?->hasRole('vendeur')) {
            return route('vendeur.dashboard');
        }

        return route('client.dashboard');
    }
}
