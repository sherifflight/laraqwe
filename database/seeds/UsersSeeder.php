<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        if ($this->command->confirm('Seed users tables?')) {
            if ($this->command->confirm('Clear users tables first?', true)) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                DB::table('users')->truncate();
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }

            Model::unguard();

            $user = User::query()->create([
                'email'      => 'root@mysite.com',
                'password'   => '123123',
                'name' => 'root'
            ]);

            /** @var User $user */

            $role = Role::query()
                ->where('name', Role::ROOT)
                ->first();
            /** @var Role|null $role */

            if ($role instanceof Role) {
                $user->assignRole($role);
            }

            Model::reguard();

            $this->command->info('Users tables seeded!');
        }
    }
}
