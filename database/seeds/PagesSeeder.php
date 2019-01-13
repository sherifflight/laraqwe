<?php

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    public function run()
    {
        if ($this->command->confirm('Seed pages table?')) {
            if ($this->command->confirm('Clear pages table first?', true)) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                DB::table('pages')->truncate();
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }

            Model::unguard();

            Page::query()->create([
                'page_name' => 'index',
                'title' => 'Hello world',
                'content' => 'Hello world! You can change this text in dashboard.'
            ]);

            Model::reguard();

            $this->command->info('Pages table seeded!');
        }
    }
}
