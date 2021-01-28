<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\InfoPost;
use App\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Ordino dal più recente al meno recente
        $posts = Post::orderBy('created_at', 'desc')->paginate(4);  //Elimino get() in quanto lo comprende -> poi vai in index.blade.php per sistemare lo slider delle pagine
        //Get tags
        $tags = tag::all();

        return view('posts.index', compact('posts', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Get tags
        $tags = tag::all();

        return view('posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Get data from form
        $data = $request->all();

        //Validazione: il this serve per richiamare la funzioni al di fuori dell'istanza
        $request->validate($this->ruleValidation());

        //Aggiungo una nuova chiave associativa: slug
        $data['slug'] = Str::slug($data['title'], '-');

        //Controllo per salvare l'immagine nel DB se viene caricata
        if (!empty($data['path_img'])) {
            $data['path_img'] = Storage::disk('public')->put('images', $data['path_img']);
        }

        //Salvataggio nel mio DB
        $newPost = new Post();
        $newPost->fill($data); //$fillable nel model

        $saved = $newPost->save();

        //InfoPost record della tabella. Facciamo fillable nel InfoPost controller NB: aggiungo use App\InfoPost. Creao in data la colonna post_id (FK)
        $data['post_id'] = $newPost->id;  //FK

        //Procedo con il fillable che dovrà essere aggiornato con MASS ASSIGN nel MODEL di InfoPost
        $newInfo = new InfoPost();
        $newInfo->fill($data);
        $infoSaved = $newInfo->save();


        //Controllo sul salvataggio e sulle rotte di destinazione
        if ($saved && $infoSaved) {
            //Controllo TAGS vuoto o meno
            if (!empty($data['tags'])) {
                //Metodo che salva i dati solo nella tabella PIVOT. Il TAGS viene dal model post.php. Poi vai nella show.php
                $newPost->Tags()->attach($data['tags']);

                //Cerco tabella PIVOT tra POSTS e TAGS creando relazione
                // id	post_id	tag_id
                // 1 	   29 	   2
                // 2 	   29 	   4
            }
            return redirect()->route('posts.index');
        } else {
            return redirect()->route('homepage');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //Non uso il find perchè cerca la PK.
        //Cerca dove slug è uguale a $slug
        $post = Post::where('slug', $slug)->first();
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $tags = Tag::all();

        //Imposto il controllo su eventuali errori di ricerca da parte dell'utente e gestisco lo stile in 404.blade.php
        if (empty($post)) {
            abort(404);
        }

        return view('posts.edit', compact('post', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Get data from form
        $data = $request->all();

        //Validazione
        $request->validate($this->ruleValidation());

        //Get post to update
        $post = Post::find($id);

        //Aggiornare slug dopo nuovo edit affinché venga sovrascritto
        $data['slug'] = Str::slug($data['title'], '-');

        //Se cambio anche l'immagine? Verifico dalla form se ho o meno un file. Nel caso in cui ci fosse vado nel DB
        if (!empty($data['path_img'])) {

            //Cancella l'immagine precedente
            if(!empty($post->path_img)) {
                Storage::disk('public')->delete($post->path_img);
            }
            $data['path_img'] = Storage::disk('public')->put('images', $data['path_img']);
        }

        //Aggiorno il DB
        $updated = $post->update($data);  //$fillable nel model

        //InfoPost update
        $data['post_id'] = $post->id;  //FK
        $info =  InfoPost::where('post_id', $post->id)->first(); //Cerco uguagliaza fra FK e post_id. Il FIRST che ritorna esattamente un oggetto.

        //MASS ASSIGN
        $infoUpdated = $info->update($data); //$fillable nel model: ogni volta che aggiungo una chiave associativa

        if ($updated && $infoUpdated) {  //&& perchè entrambe devono essere vere. Se al primo controllo IF uno dei due non va a buon fine si passa direttamente all ELSE
            //Update tags
            if (!empty($data['tags'])) {
                //Sincronizza con precedenti tag indicati
                $post->tags()->sync($data['tags']);
            } else {
                //Se non c'è sync con precedenti tag indicati elimina i vecchi
                $post->tags()->detach();
            }
            return redirect()->route('posts.show', $post->slug);
        } else {
            return redirect()->route('homepage');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //$post = Post::find($id) compatto la versione con variabile e istanza

        $title = $post->title;
        $img = $post->path_img;

        $post->tags()->detach();

        $deleted = $post->delete();

        //Controllo sulla cancellazione e imposto la section che dovrò stilare nel file index.blade.php nel file show.bòade.php imposto la form con la cancellazione del post
        if ($deleted) {
            if (!empty($post->path_img)) {
                Storage::disk('public')->delete($img);
            }
            return redirect()->route('posts.index')->with('post-deleted', $title);
        } else {
            return redirect()->route('homepage');
        }
    }


    //Regole per la validazione
    private function ruleValidation() {
        return [
            'title' => 'required',
            'body' => 'required',
            'path_img' => 'image'
        ];
    }
}
