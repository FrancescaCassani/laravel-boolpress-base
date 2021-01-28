<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**RELAZIONI FRA MODEL DIVERSI: Prima creo le tabelle, le FK e popolo con dati poi nel MODEL imposto il tipo di relazione: OTO, OTM, MTO, MTM */

    //COMMENTS - POSTS (tabella secondaria alla primaria)
    public function Post() {
        return $this->belongsTo('App\Post');
    }


}
