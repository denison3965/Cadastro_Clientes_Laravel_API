<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;

class ControladorProduto extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::all();
        return $produtos;

    }

    public function indexView()
    {
        $produtos = Produto::all();
        $categorias = Categoria::all();
        return view('produtos', compact(['produtos', 'categorias']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('novoproduto', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nome = $request->input('nome');
        $preco = $request->input('preco');
        $estoque = $request->input('estoque');
        $categoria_id = $request->input('categoria_id');

        $produto = new Produto();
        $produto->nome = $nome;
        $produto->estoque = $estoque;
        $produto->preco  = $preco;
        $produto->categoria_id = $categoria_id;


        $produto->save();

   
        return json_encode($produto);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto =  Produto::find($id);

        if (isset($produto))
        {
            return json_encode($produto);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $produto = Produto::find($id);
        $categorias = Categoria::all();

        if (isset($produto))
        {
            return view('editarproduto', compact(['produto', 'categorias']));
        }
        else
        {
            return redirect("/produtos");
        }
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
        
        $produto = Produto::find($id);

        if (isset($produto))
        {

            
            $nome = $request->input('nome');
            $preco = $request->input('preco');
            $estoque = $request->input('estoque');
            $categoria_id = $request->input('categoria_id');
    
            $produto->nome = $nome;
            $produto->estoque = $estoque;
            $produto->preco  = $preco;
            $produto->categoria_id = $categoria_id;
    

            $produto->save();

            return json_encode($produto);

        }

        return response('Produto não encontrado', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = Produto::find($id);

        if(isset($produto))
        {
            $produto->delete();
            return response('OK', 200);
        }

        return response('Produto não encontrado', 404);
    }
}
