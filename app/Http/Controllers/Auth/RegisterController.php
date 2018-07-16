<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\mailme;
use Illuminate\Support\Facades\Mail;

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
    protected $redirectTo = '/home';

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
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
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
        $info = new \stdClass();
        $info->username = $data['name'];
        $info->email = $data['email'];
        $info->company = $data['companyname'];
        $info->created_at = date('Y-m-d H:i:s');

        if ($data['userrole'] == "customer")
        {
            Mail::to('williamding131@outlook.com')->send(
                new mailme("ADMIN_REGISTER_CUSTOMER", $info));
        }
        else if ($data['userrole'] == "business")
        {
            Mail::to('williamding131@outlook.com')->send(
                new mailme("ADMIN_REGISTER_BUSINESS", $info));
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'companyname' => $data['companyname'],
            'package' => $data['package'],
            'userrole' => $data['userrole'],
        ]);
    }
}
