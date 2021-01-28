<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoPost extends Model
{
    //MASS ASSIGN DI INFOPOST
    protected $fillable = [
        'post_id',
        'post_status',
        'comment_status'
    ];

    //Per non far gestire a Laravel create e updated_at (proprietà del nostro modello)
    public $timestamps = false;


    /**RELAZIONI FRA MODEL DIVERSI: Prima creo le tabelle, le FK e popolo con dati poi nel MODEL imposto il tipo di relazione: OTO, OTM, MTO, MTM */

    //INFO_POSTS - POSTS (tabella secondaria alla primaria)
    public function post() {
        return $this->belongsTo('App\Post');
    }


    /** poi continua in show.blade.php per visualizzare i dati di INFOPOST*/
}
