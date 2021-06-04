@extends('layouts.app', ["current" => "produtos"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <h5 class="card-title">Cadastro de Categorias</h5>
            <table class="table table-ordered table-hover" id="tabelaProdutos">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome do produto</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Categoria</th>
                        <th>Ação</th>
                    </tr>

                </thead>

                <tbody>

                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <button class="btn btn-sm btn-primary" onclick="novoProduto()" >Novo Produto</button>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="dlgProdutos">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" id="formProduto">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo Produto</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" class="from-control">
                        <div class="from-group mt-3">
                            <label for="nomProduto" class="control-label">Nome do Produto</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="" id="nomeProduto" placeholder="Nome do produto">
                            </div>
                        </div>

                        <div class="from-group mt-3">
                            <label for="nomProduto" class="control-label">Preço do Produto</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="" id="precoProduto" placeholder="Preço do produto">
                            </div>
                        </div>

                        <div class="from-group mt-3">
                            <label for="nomProduto" class="control-label">Quantidade do Produto</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="" id="quantidadeProduto" placeholder="Quantidade do produto">
                            </div>
                        </div>

                        <div class="from-group mt-3">
                            <label for="nomProduto" class="control-label">DepartamentoProduto do Produto</label>
                            <div class="input-group">
                                <select class="form-control" name="" id="departamentoProduto">
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <button type="cancel" class="btn btn-secondary" data-dismiss="modal" >Cancelar</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection()

@section('javascript')
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })

        function novoProduto()
        {
            $('#id').val('')
            $('#nomeProduto').val('')
            $('#precoProduto').val('')
            $('#quantidadeProduto').val('')
            $('#dlgProdutos').modal('show')
            
        }
        function montarLinha(p)
        {
            let linha = "<tr>" +
                    "<td>" + p.id  + "</td>" +
                    "<td>" + p.nome + "</td>" +
                    "<td>" + p.preco + "</td>" +
                    "<td>" + p.estoque + "</td>" +
                    "<td>" + p.categoria_id + "</td>" +
                    "<td>" + 
                        '<button class="btn btn-sm btn-primary" onclick="editar(' + p.id+')">Editar</button>' + 
                        '<button class="btn btn-sm  btn-danger"  onclick="remover(' + p.id+')">Apagar</button>' +
                    "</td>"  +
                    "</tr>";
            return linha;
                     
        }

        function criarProduto()
        {
            produto = {
                nome: $('#nomeProduto').val(),
                preco:$('#precoProduto').val(),
                estoque:$('#quantidadeProduto').val(),
                categoria_id: $('#departamentoProduto').val()
            }
            $.post('/api/produtos', produto, (data) => {
                produto = JSON.parse(data);
                linha = montarLinha(produto);
                $("#tabelaProdutos>tbody").append(linha);
            })
        }

        function remover(id)
        {
            $.ajax({
                type:"DELETE",
                url: "/api/produtos/" + id,
                context: this,
                success: () => {
                    linhas = $("#tabelaProdutos>tbody>tr");
                    e = linhas.filter( (i, elemento) => {
                        return elemento.cells[0].textContent == id;
                    })

                    if (e)
                        e.remove();


                },
                error: (error) => {
                    console.log(error)
                }
            })
        }

        function salvarProduto()
        {
            produto = {
                id :  $("#id").val(),
                nome: $('#nomeProduto').val(),
                preco:$('#precoProduto').val(),
                estoque:$('#quantidadeProduto').val(),
                categoria_id: $('#departamentoProduto').val()
            }

            $.ajax({
                type: "PUT",
                url:"/api/produtos/" + produto.id,
                data: produto,
                context: this,
                success: (data) => {
                    $produto = JSON.parse(data);
                    linhas = $("#tabelaProdutos>tbody>tr")
                    e = linhas.filter( (i, e) => {
                        return ( e.cells[0].textContent == produto.id );
                    })

                    if (e)
                    {
                        e[0].cells[0].textContent = produto.id
                        e[0].cells[1].textContent = produto.nome
                        e[0].cells[2].textContent = produto.preco
                        e[0].cells[3].textContent = produto.estoque
                        e[0].cells[4].textContent = produto.categoria_id
                    }
                },
                error: (err) => {
                    console.log(err)
                }
            })

        }

        $("#formProduto").submit( function(event){
            event.preventDefault();
            if($("#id").val() != '')
                salvarProduto();
            else
                criarProduto();
            $('#dlgProdutos').modal('hide')
        })

        function editar(id)
        {   
            $.getJSON('/api/produtos/' + id, (data) => {
                console.log(data)
                $('#id').val(data.id)
                $('#nomeProduto').val(data.nome)
                $('#precoProduto').val(data.preco)
                $("#quantidadeProduto").val(data.estoque)
                $("#departamentoProduto").val(data.categoria_id)
                $('#dlgProdutos').modal('show')
            })
        }

        function caregarProdutos() {

            $.getJSON('/api/produtos', function (produtos) {
                for (i=0; i < produtos.length; i++)
                {
                    linha = montarLinha(produtos[i]);
                    $("#tabelaProdutos>tbody").append(linha);
                }
            })

            
        }

        function caregarCategorias() {
            $.getJSON('/api/categorias', function(data) { 
                for (i=0; i<data.length; i++)
                {
                    opcao = '<option value="' + data[i].id + '">' + data[i].nome + '</option>';
                    $("#departamentoProduto").append(opcao);
                }
            })

        }

        $(function(){
            caregarCategorias()
            caregarProdutos()
        })

    </script>
@endsection
