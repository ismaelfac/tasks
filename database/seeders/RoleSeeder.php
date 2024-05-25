<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = file_get_contents("database/json_seeders/roles.json");
        $roles = json_decode($data, true);
        foreach ($roles as $key => $value) {
            $role = Role::create([
                'code' => $key,
                'name' => $value['name'],
                'display_name' => $value['display_name'],
                'description' => $value['description'],
                'all_roles' => $value['all_roles'],
                'active' => $value['active']
            ]);
        }
    }
}
