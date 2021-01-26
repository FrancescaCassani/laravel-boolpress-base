<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //L'ordine in cui li aggiungo è l'ordine di aggiunta qui dentro
        $this->call([
            PostsTableSeeder::class,
        ]);
    }
}
