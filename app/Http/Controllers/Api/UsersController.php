<?php

namespace App\Http\Controllers\Api;

use App\User;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;
use League\Fractal\Resource\Collection;
use App\Repositories\UserRepositoryEloquent;

class UsersController extends Controller
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

    public function __construct(Manager $fractal, UserTransformer $userTransformer, UserRepositoryEloquent $userRepository)
    {
        $this->fractal = $fractal;;
        $this->userTransformer = $userTransformer;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $users = $this->userRepository->all(); // Get users from DB4
        $users = new Collection($users, $this->userTransformer); // Create a resource collection transformer
        $users = $this->fractal->createData($users); // Transform data

        return $users->toArray(); // Get transformed array of data
    }

    public function get($id)
    {
        $user = $this->userRepository->find($id);
        $user = new Item($user, $this->userTransformer); // Create a resource collection transformer
        $user = $this->fractal->createData($user); // Transform data

        return $user->toArray(); // Get transformed array of data
    }
}
