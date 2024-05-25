<?php

namespace App\Http\Controllers\Auth;

use App\Cms\User\UserRepo;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function getRepo(): UserRepo
    {
        return new UserRepo();
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => User::whereRelation('roles', 'all_roles', '=', 0)->with('roles:id,name')->get(),
            'success' => 200]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreClientRequest  $request
     * @return ResponseFactory|Response
     */
    public function store(Request $request): Response|ResponseFactory
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        try {
            return jsend_success($this->getRepo()->store($request));
        } catch (\Exception $e) {
            Log::info('Error Store User', [$e->getMessage()]);
            return jsend_error('Error Store User: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        User::deleted($user);
        return response()->json(['success' => 200]);
    }
}
