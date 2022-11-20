<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRegister;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use HttpResponses;
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function register(StoreUserRequest $request){

        $request->validated($request->all());

        $user = User::create(array(
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password)
            ));
        return $this->sucess([
            'User'      => $user,
            'token'     => $user->createToken('API TOKEN of '.$user->name)->plainTextToken
        ]);
    }

    public function logIn(LoginUserRequest $request){

        $request->validated($request->all());

        if (!Auth::attempt($request->only(['email', 'password']))) {
           $this->sucess('', 'Creantials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->sucess(
            [
                'status'     => true,
                'message'    => 'User Logged In Successfully',
                'token'      => $user->createToken("API TOKEN")->plainTextToken
                ],
            'User Logged In Successfully',
            200
        );
    }
    public function logout(Request $request){
        Auth::user()->currentAccessToken()->delete();
        return $this->sucess('','Log out');
    }

}
