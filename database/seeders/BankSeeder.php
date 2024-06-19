<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hitBankApi = Http::get('https://raw.githubusercontent.com/dayCod/list-bank-json/main/list-bank.json');

        foreach ($hitBankApi->object() as $bank) {
            DB::table('banks')
                ->insert([
                    'name' => $bank->name,
                    'code' => $bank->code,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
        }
    }
}
