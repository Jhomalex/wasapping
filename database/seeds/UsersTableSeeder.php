<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        User::truncate();

        $adminRole = Role::create(['name' => 'Admin']);
        $clienteRole = Role::create(['name' => 'Cliente']);

        $admin= new User;
        $admin->nombre="Jhonatan Malara";
        $admin->foto="jhonatan_malara.jpg";
        $admin->email="jhonatan@yodonante.com";
        $admin->password=bcrypt('Halamadrid');
        $admin->save();

        $admin->assignRole($adminRole);

        $cliente= new User;
        $cliente->nombre="Felipe Benites";
        $cliente->foto="cliente.png";
        $cliente->email="felipe@yodonante.com";
        $cliente->password=bcrypt('pipo123');
        $cliente->save();

        $cliente->assignRole($clienteRole);

    }
}
