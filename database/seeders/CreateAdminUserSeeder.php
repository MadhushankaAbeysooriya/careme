<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Abeysooriya Patabendige Lahiru Madhushanka',
            'email' => 'lahiru.slsc@gmail.com',
            'password' => bcrypt('123456'),
            'phone' => '0719449908',
            'gender' => 'M',
        ]);

        //$user = User::find(1);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
