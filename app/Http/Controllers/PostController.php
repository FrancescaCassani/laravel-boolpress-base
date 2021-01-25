<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
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
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
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

        //Controllo sul salvataggio e sulle rotte di destinazione
        if ($saved) {
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
        return view('posts.edit', compact('post'));
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

        if ($updated) {
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
    public function destroy($id)
    {
        //
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
