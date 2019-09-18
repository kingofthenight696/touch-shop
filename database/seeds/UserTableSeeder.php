<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => config('credentials.test_admin.name'),
            'role_id' => Role::where('name', Role::ADMIN_ROLE)->first()->id,
            'email' => config('credentials.test_admin.email'),
            'password' => bcrypt(config('credentials.test_admin.password')),
        ]);
    }
}
