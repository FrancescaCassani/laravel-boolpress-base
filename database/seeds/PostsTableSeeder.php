<?php

use Illuminate\Database\Seeder;
use App\Post;
use Illuminate\Support\Str; //Porto dentro il mio model

use Faker\Generator as Faker; //Per importare la libreria già presente in Laravel nel mio seeder

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        /**AGGIUNTA DATI CON FRAMEWORK: FAKER*/
        //Post::truncate(); se voglio eliminare tutti i post presenti nel DB. NB:usare con cautela

        for ($i=0; $i < 23; $i++) {
            $newPost = new Post(); //Creazione nuova istanza

            $title = $faker->text(50);  //---> Vedi https://fakerphp.github.io/formatters/text-and-paragraphs/

            $newPost->title = $title; //Creazione proprietà
            $newPost->body = $faker->paragraph(2, true); //---> Vedi https://fakerphp.github.io/formatters/text-and-paragraphs/
            $newPost->slug = Str::slug($title, '-');; //Creazione proprietà

            $newPost->save(); //Salvo la mia nuova istanza
        }
    }
}
