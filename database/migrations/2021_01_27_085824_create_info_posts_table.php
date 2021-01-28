<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /**
    * MIGRAZIONE PER TABELLE RELAZIONALI
    * ---> https://laravel.com/docs/8.x/migrations#creating-columns
    */
    public function up()  //php artisan make:model InfoPostsTable --migration
    {
        //Migration tabella info_post
        Schema::create('info_posts', function (Blueprint $table) {
            $table->id();
            //Imposto il nome della FK tra tabelle - Creo una colonna BigInteger senza assegnare valore
            $table->unsignedBigInteger('post_id');

            //Qui creiamo la relazione tra le tabelle
            $table->string('post_status', 10); //-----> Che imposterò in BLADE come = Publica, Private, Draft
            $table->string('comment_status', 10); //--> Che imposterò in BLADE come = Open, Closed, Private (accesso solo per alcuni utenti)

            //Commentiamo il TimeStamps in quanto teniamo quello generato dai post
            //$table->timestamps();


            /** Dopo aver impostato le relazioni spostati in InfoPost.php per gestire la questione TimeStamps, ossia al----> MODEL */


            /**
            ******* TABELLA RELAZIONALE TRA POST E INFO_POST. Alla fine lancio il comando php artisan migrate da terminale poi php artisan make:seeder InfoPostsTableSeeder
            */
            $table->foreign('post_id') //FK che punta alla colonna ID della tabella posts
                  ->references('id')
                  ->on('posts')
                  ->onDelete('cascade'); //Se il post viene eliminato, a cascata elimino anche le info_post e le altre relazioni con la tabella posts
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_posts');
    }
}
