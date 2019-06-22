<?php

namespace App\Http\Controllers\Auth;

use App\Models\UserType;
use App\Traits\UserRoleTrait;
use Illuminate\Http\Response;
use App\Jobs\SendNewUserRegistration;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;

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

    use RegistersUsers, UserRoleTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'type' => ['required', Rule::in(['volunteer', 'organize'])],
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response | mixed
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return ($response = $this->registered($request, $user))
            ? $response : redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $receive_news = isset($data['receive_news']) ? 'yes': 'no';
        return User::create([
            'name' => $data['name'],
            'receive_news' => $receive_news,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if (auth() !== null && auth()->user() !== null && User::isAdminUser(auth()->user())) {//check if admin register
            $user->setStatus('approved');
        } else {
            $this->dispatch(new SendNewUserRegistration($user));
        }
        // add user type for first register
        $userType = new UserType(['type_user_id' => $this->getValidateUserType($request->get('type'))]);
        $user->userType()->save($userType);
        if ($request->ajax()) {
            return [
                'success' => true,
                'user' => $user->transformUser()
            ];
        }
        return false;
    }

    protected function user_type_wrapper($title)
    {
        return str_replace('-', '_', $title);
    }

    protected function getValidateUserType($type)
    {
        $userTypeId = $this->getTypeUserId($this->user_type_wrapper($type));
        return $userTypeId ?? null;
    }
}
