<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\Rules;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class RegisteredUserController extends Controller
{

    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];   


    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'could_not_create_token'], 500);
        }

        $user = JWTAuth::user();

        $tokenOne = $request->user()->createToken('token');

        return response()->json(compact('token', 'user'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => ['required', 'string', 'max:50'],
            'second_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'personal_phone' => ['required', 'string', 'max:10','unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address' => ['required', 'string', 'max:200'],
            'birthdate' => ['required', 'string', 'max:10'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'personal_phone' => $request->personal_phone,
            'address' => $request->address,
            'birthdate' => $request->birthdate,
            'role_id' =>3
        ]);

        $token = JWTAuth::fromUser($user);
        event(new Registered($user));
 
        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'token_expired'], /* $e->getStatusCode() */ 400);
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'token_invalid'], /* $e->getStatusCode() */ 400);
        } catch (JWTException $e) {
        return response()->json(['message' => 'token_absent'], /*$e->getStatusCode()*/ 400 );
        }
        return response()->json(compact('user') , 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}
