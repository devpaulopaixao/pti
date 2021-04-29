<?php

use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('users')->delete();

        Role::create(['name' => 'Admin']);

        $role = Role::create(['name' => 'SuperAdmin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user = User::create([
        	'name' => 'Paulo Paixão',
        	'email' => 'paulinhohenrique90@yahoo.com.br',
            'password' => bcrypt('paixao')
        ]);

        $user->assignRole([$role->id]);

        Model::reguard();
    }
}
