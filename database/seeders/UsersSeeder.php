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

        $user2 = User::create([
            'name' => 'User Worker',
            'email' => 'userworker@mail.com',
            'password' => '123456',
            'active' => true
        ]);
        $this->generateAccessTokenForUser($user2->id);
        $user2->createToken('authToken')->accessToken;
        $user2->roles()->sync([2 => ['active' => true]]); //update roles
    }

    protected function generateAccessTokenForUser($userId)
    {
        // Obtiene el usuario por su ID
        $user = \App\Models\User::find($userId);
        if (!$user) {
            return null;
        }

        // Revocar tokens de acceso existentes del usuario
        $this->revokeTokenAccess($user);

        // Crea un nuevo cliente Passport
        $clientRepository = app(ClientRepository::class);
        $client = $clientRepository->createPersonalAccessClient(
            null, 'Personal Access Client', config('app.url')
        );

        // Crea un token de acceso personal
        $token = $user->createToken('tasks'); // nombre del cliente

        // Retorna el resultado del token de acceso
        return $token;
    }

    protected function revokeTokenAccess($user)
    {
        // Revoca todos los tokens de acceso existentes del usuario
        $user->tokens()->delete();
    }
}
