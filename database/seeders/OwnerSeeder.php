<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerExists = User::where('role', User::ROLE_OWNER)->exists();

        if(!$ownerExists) {
            
            User::create([
                'name'  =>  'owner',
                'email' =>  'owner@cafecms.com',
                'password'    => Hash::make('password'),
                'role'        => User::ROLE_OWNER,
                'status'      => User::STATUS_APPROVED,
                'approved_by' => null,
                'approved_at' => now(),
            ]);
            
        }
    }
}
