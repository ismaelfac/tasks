<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = file_get_contents("database/json_seeders/permissions.json");
        $permissions = json_decode($data, true);
        foreach ($permissions as $key => $value) {
            Permission::create([
                'code' => $key,
                'name' => $value['name'],
                'display_name' => $value['display_name'],
                'description' => $value['description'],
                'module' => $value['module'],
                'type' => $value['type'],
                'active' => $value['active']
            ]);

        }
    }
}
