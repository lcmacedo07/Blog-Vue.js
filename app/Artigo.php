<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Artigo extends Model
{
    use SoftDeletes;

    protected $fillable = ['titulo', 'descricao', 'conteudo', 'data'];

    protected $dates = ['deleted_at'];

    public function user() {
     
        return $this->belongsTo('App\User');    
    }

    public static function listaArtigos($paginate) {

        $listaArtigos = DB::table('artigos')
                        ->join('users', 'user_id', '=', 'artigos.user_id')
                        ->select('artigos.id', 'artigos.titulo', 'artigos.descricao', 'users.name', 'artigos.data')
                        ->whereNull('deleted_at')
                        ->paginate(5);

        return $listaArtigos;
    } 

    public static function listaArtigosSite($paginate) {

        $listaArtigos = DB::table('artigos')
                        ->join('users', 'user_id', '=', 'artigos.user_id')
                        ->select('artigos.id', 'artigos.titulo', 'artigos.descricao', 'users.name as autor', 'artigos.data')
                        ->whereNull('deleted_at')
                        ->whereDate('data', '<=', date('Y-m-d'))
                        ->paginate(5);

        return $listaArtigos;
    } 
}
