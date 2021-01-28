<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //MASS ASSIGN
    protected $fillable = [
        'title',
        'body',
        'slug',
        'path_img'
    ];


    /**RELAZIONI FRA MODEL DIVERSI: Prima creo le tabelle, le FK e popolo con dati poi nel MODEL imposto il tipo di relazione: OTO, OTM, MTO, MTM */

    //POSTS - INFO_POSTS
    public function InfoPost(){
        return $this->hasOne('App\InfoPost');  //Namespace dei due MODEL
    }


    //POSTS - COMMENTI
    public function Comments(){
        return $this->hasMany('App\Comment'); //Namespace dei due MODEL
    }


    //POSTS - TAGS
    public function Tags(){
        return $this->belongsToMany('App\Tag'); //Namespace dei due MODEL
    }

    /**NB: tutti Seeder devono essere aggiunti come array nel dataBaseSeeder*/
}
