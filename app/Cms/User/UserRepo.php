<?php

namespace App\Cms\User;

use App\Cms\BaseRepo\BaseRepo;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\ClientRepository;

class UserRepo extends BaseRepo
{
    public function getModel(): User
    {
        return new User();
    }



    function store($request)
    {
        try {
                $user = $this->getModel()->create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                    'active' => true
                ]);
                Log::info('User creado: ',[$user]);
                $this->generateAccessTokenForUser($user->id);
                $user->roles()->sync([3 => ['active' => true]]);
                //$user->companies()->sync([3 => ['active' => true]]);
                event(new Registered($user));
                if (!empty($user->createToken('Token')->accessToken)) {
                    $token = $user->createToken('Token')->accessToken;
                    return ['data' => $user, 'access_token' => $token, 'success' => 200];
                }
            
        } catch (\Exception $e) {
            Log::error('Error Store User', [$e->getMessage()]);
        }
    }

    protected function generateAccessTokenForUser($userId)
    {
        // Obtener el usuario por su ID
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return null;
        }

        // Revocar tokens de acceso existentes del usuario
        $this->revokeTokenAccess($user);

        // Crear un nuevo cliente Passport
        $clientRepository = app(ClientRepository::class);
        $client = $clientRepository->createPersonalAccessClient(
            null, 'Personal Access Client', config('app.url')
        );

        // Crear un token de acceso personal
        $token = $user->createToken('tasks'); // nombre del cliente aquí

        // Retornar el resultado del token de acceso (opcional)
        return $token;
    }

    protected function revokeTokenAccess($user): void
    {
        // Revocar todos los tokens de acceso existentes del usuario
        $user->tokens()->delete();
    }
}
