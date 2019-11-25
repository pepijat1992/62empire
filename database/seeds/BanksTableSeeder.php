<?php

use Illuminate\Database\Seeder;

use App\Models\Bank;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::create([
            'name' => 'Affin Bank',
            'image' => 'images/banks/affin.png'
        ]);
        Bank::create([
            'name' => 'Alliance Bank',
            'image' => 'images/banks/alliance_bank.png'
        ]);
        Bank::create([
            'name' => 'AmBank',
            'image' => 'images/banks/ambank.png'
        ]);
        Bank::create([
            'name' => 'CIMB Bank',
            'image' => 'images/banks/cimb.png'
        ]);
        Bank::create([
            'name' => 'Hong Leong Bank',
            'image' => 'images/banks/hong_leong.png'
        ]);
        Bank::create([
            'name' => 'HSBC Bank',
            'image' => 'images/banks/hsbc.png'
        ]);
        Bank::create([
            'name' => 'Bank Islam',
            'image' => 'images/banks/bank_islam.png'
        ]);
        Bank::create([
            'name' => 'OCBC Bank',
            'image' => 'images/banks/ocbc.png'
        ]);
        Bank::create([
            'name' => 'MayBank',
            'image' => 'images/banks/maybank.png'
        ]);
        Bank::create([
            'name' => 'Public Bank',
            'image' => 'images/banks/public_bank.png'
        ]);
        Bank::create([
            'name' => 'RHB Bank',
            'image' => 'images/banks/rhb.png'
        ]);
        Bank::create([
            'name' => 'Standard Charted',
            'image' => 'images/banks/standard_chartered.png'
        ]);
        Bank::create([
            'name' => 'UOB',
            'image' => 'images/banks/uob.png'
        ]);
    }
}
