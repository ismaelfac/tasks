<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Laravel\Passport\ClientRepository;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Ismael E. Lastre Alvarez',
            'email' => 'ismaelfac@gmail.com',
            'password' => 'BrwQ12-123',
            'active' => true
        ]);
        $this->generateAccessTokenForUser($user1->id);
        $user1->createToken('authToken')->accessToken;
        $user1->roles()->sync([1 => ['active' => true]]); //update roles
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

    protected function revokeTokenAccess($user)
    {
        // Revocar todos los tokens de acceso existentes del usuario
        $user->tokens()->delete();
    }
}
