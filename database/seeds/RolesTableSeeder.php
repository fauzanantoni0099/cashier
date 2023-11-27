<?php

use App\User;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles=[
          'Super Admin', 'Kasir', 'Admin'
        ];
        foreach ($roles as $role)
        {
            \Spatie\Permission\Models\Role::create([
                'name'=>$role,
                'guard_name'=>'web',

            ]);
        }
    }
}
