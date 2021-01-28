<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Post;
use App\Comment;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker) //php artisan db:seed -- class=CommentsTableSeeder
    {
        //Creare un'interazione per ogni mio post: rendo tutti i post e per ognuno creo un ID, author e text(proprietà di Comment)
        $posts = Post::all();

        //Genero 3 commenti casuali per ogni post
        foreach ($posts as $post) {

            for ($i=0; $i < 3; $i++) {
                //Creo istanza
                $newComment = new Comment();

                /**Valori colonne tra dato post e comment*/
                //FK di collegamento fra le tabelle POSTS e COMMENTS
                $newComment->post_id = $post->id;

                //Popolo le colonne della tabella COMMENTS con dati fake
                $newComment->author = $faker->userName();
                $newComment->text = $faker->sentence(10);//passo 10 parole per ogni commento

                //Salvataggio in DB, poi lancio il comando php artisan db:seed --class=CommentsTableSeeder per popolare la tabella mentre il php artisan make:seeder CommentsTableSeeder per creare il file nei SEEDS
                $newComment->save();
            }
        }
    }
}
