<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryEloquent;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;
use League\Fractal\Manager;
use Response;
use Validator;

class RegisterController extends Controller
{
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * @var UserRepositoryEloquent
     */
    protected $userRepository;

    public function __construct(
        Manager $fractal,
        UserTransformer $userTransformer,
        UserRepositoryEloquent $userRepository
    ) {
        $this->fractal = $fractal;
        $this->userTransformer = $userTransformer;
        $this->userRepository = $userRepository;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $this->userRepository->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);
        $user = $this->userRepository->first();
        $token = JWTAuth::fromUser($user);

        // @todo: send email to user verify

        return Response::json(compact('token'));
    }
}
