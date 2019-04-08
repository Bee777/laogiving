<?php

use App\Models\TypeUser;
use Illuminate\Database\Seeder;

class TypeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeUser::create(['name' => 'super_admin']);
        TypeUser::create(['name' => 'admin']);
        TypeUser::create(['name' => 'volunteer']);
        TypeUser::create(['name' => 'organize']);
    }
}
