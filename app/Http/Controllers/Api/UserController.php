<?php


namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'signup', 'rewind']]);
    }

    /**
     * Fonction de login qui génère un token JWT
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request) {
        $validation = $this->validateInputs($request, [
            'login' => 'required',
            'password' => 'required',
        ]);

        if(!empty($validation) && !is_array($validation)) { // traitement classique
            $credentials = [
                'username' => $request->input('login'),
                'password' => $request->input('password'),
            ];

            if(! $token = Auth::guard('api')->attempt($credentials) ) {
                return $this->response(null, false, $this->error('USER_NOT_FOUND','Utilisateur introuvable'), 400 );
            }
            $user = Auth::guard('api')->user();

            return $this->response([
                'token' => $token,
            ]);
        }
        return $this->response( null, false, $validation, 400 ); // erreur liée aux inputs
    }

    public function logout()
    {
        auth()->logout();

        return $this->response(null, false, null, 400);
    }

}
