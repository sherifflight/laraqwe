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
                'content' => '<p></p><p style="text-align: left; line-height: 3; margin-left: 25px;"><span style="font-size: 13.5px; letter-spacing: 0.13px; font-weight: bold;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span><br></p><table class="table table-bordered"><tbody><tr><td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</td><td><p style="margin-left: 25px;"><br></p><img src="https://cdn.pixabay.com/photo/2015/06/22/11/07/rose-817431_960_720.jpg" style="width: 229px; height: 153.144px;"><p style="margin-left: 25px;"><br></p></td></tr><tr><td><br><img src="https://wallpaperbrowse.com/media/images/3848765-wallpaper-images-download.jpg" style="width: 201px; height: 113.006px; float: none;"></td><td><p style="">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p></td></tr></tbody></table><br><p><br></p><p></p><div style="text-align: left; margin-left: 25px;"><span style="color: rgb(0, 0, 0); letter-spacing: 0.01em; background-color: rgb(255, 255, 255);">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></div><span style="color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;="" letter-spacing:="" normal;="" text-align:="" justify;"=""><br></span><p></p><p><span style="color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;="" letter-spacing:="" normal;="" text-align:="" justify;"=""><br></span></p><p></p><p style=""><span style="color: rgb(0, 0, 0); font-family: " open="" sans",="" arial,="" sans-serif;="" font-size:="" 14px;="" letter-spacing:="" normal;="" text-align:="" justify;"=""><span style="color: rgb(122, 137, 148); letter-spacing: 0.13px; text-decoration-line: underline; font-weight: bold;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span></span></p><ul><li style="margin-left: 25px;"><span style="letter-spacing: 0.13px;">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</span></li><li style="margin-left: 25px;"><span style="letter-spacing: 0.13px;">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</span></li><li style="margin-left: 25px;"><span style="letter-spacing: 0.13px;">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</span><span style="letter-spacing: 0.13px;"><br></span><br></li></ul><p style="margin-left: 25px;"><br></p><p style="margin-left: 25px;"><br></p><iframe src="//www.youtube.com/embed/r5bhZwDq93c" width="640" height="360" frameborder="0"></iframe><p style="margin-left: 25px;"><br></p><p></p>'
            ]);

            Model::reguard();

            $this->command->info('Pages table seeded!');
        }
    }
}
