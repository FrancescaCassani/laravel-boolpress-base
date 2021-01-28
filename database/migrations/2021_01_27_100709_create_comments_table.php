<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
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
    public function up() //php artisan make:model Comment --migration
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('author', 50);
            $table->string('text');
            $table->timestamps();


            /**
            ******* TABELLA RELAZIONALE TRA POST E COMMENT. Alla fine lancio il comando php artisan migrate da terminale poi php artisan make:seeder CommentsTableSeeder
            */
            $table->foreign('post_id')
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
        Schema::dropIfExists('comments');
    }
}
