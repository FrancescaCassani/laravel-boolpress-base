<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Post;
use App\InfoPost;

class InfoPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker) //Passo automaticamente un'istanza di Faker. //php artisan db:seed -- class=InfoPostsTableSeeder
    {
        //Creare informazioni per ogni mio post: prendo tutti i post e per ognuno creo un ID, post_status e comment_status(proprietà di InfoPost)
        $posts = Post::all();

        foreach ($posts as $post) {
            //Creo istanza
            $newInfo = new InfoPost();

            /**Valori colonne tra dato post e info_post*/
            //FK di collegamento fra le tabelle POSTS e INFOPOSTS
            $newInfo->post_id = $post->id;

            //Popolo le colonne della tabella INFOPOSTS con dati fake
            $newInfo->post_status = $faker->randomElement(['public', 'private', 'draft']);
            $newInfo->comment_status = $faker->randomElement(['open', 'closed', 'private']); //---> https://fakerphp.github.io/formatters/numbers-and-strings/#randomelement

            //Salvataggio in DB, poi lancio il comando php artisan db:seed --class=InfoPostsTableSeeder per popolare la tabella mentre il php artisan make:seeder InfoPostTableSeeder per creare il file nei SEEDS
            $newInfo->save();

        }
    }
}
