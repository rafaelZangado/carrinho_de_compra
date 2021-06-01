<?php
    print '	<form method="GET" >
                <label>Codigo Produto:</label>
                <input type="text"   type="submit" name="codProduto" value="" style="width: 20%;">
                                            
                <input type="submit"class="btn btn-xs btn-primary" data-toggle="modal" name="comprar" value="comprar">
                <form>
            </form>';

    if (!isset($_SESSION['itens'])) {
        $_SESSION['itens'] = array();
    }
    //ADD PRODUTO

    if (isset($_GET['comprar'])) {
        //ADD CARRINHO
        $codProduto = $_GET['codProduto'];


        if (!isset($_SESSION['itens'][$codProduto])) {
            $_SESSION['itens'][$codProduto] = 1;
        } else {
            $_SESSION['itens'][$codProduto] += 1;
        }
    }


    if (count($_SESSION['itens']) == 0) {
        $_SESSION['carrinho_vazio'] = " O Carrinho está  vazio";
        $_SESSION['ValorFinal'] = 0;
    } else {
        $_SESSION['dados'] = array();

        foreach ($_SESSION['itens'] as $codProduto => $quantidade) {
            $result_usuario    = "SELECT * FROM produto WHERE codProduto='$codProduto'";
            $resultado_Produtos = mysqli_query($conn, $result_usuario);
            $listaProdutos = mysqli_fetch_assoc($resultado_Produtos);
            $total = $quantidade * $listaProdutos['preco'];
            $FinalTotal = $total + $FinalTotal;
            $_SESSION['ValorFinal'] = $FinalTotal;
            print ' 
                <table class="table">
                <thead>
                    <tr>
                        <th>cod</th>
                        <th>Titulo do Produto</th>
                        <th>quantidade</th>
                        <th>Preço R$</th>
                        <th>Preço  x Quantidade R$</th>
                        <th >AÇÃO</th>
                    </tr>
                </thead>
                <tbody>					
                    <tr>
                        <td>' . $listaProdutos['codProduto'] . '</td>            
                        <td>' . $listaProdutos['titulo_produto'] . '</td>             
                        <td>' . $quantidade . '</td>           
                        <td>' . $listaProdutos['preco'] . '</td>
                        <td>' . $total . '</td>
                        <td>														
                            <a class="btn btn-xs btn-danger"  href="db/cancelarPedido.php?cancelar=carrinho&codProduto=' . $codProduto . '">REMOVER</a>	
                            <i class="glyphicon glyphicon-tags"></i>							
                        </td>
                    </tr>             
                </tbody>
                </table>
                ';

            array_push(
                $_SESSION['dados'],
                array(
                    'id_produto' => $codProduto,
                    'codProduto' => $listaProdutos['codProduto'],
                    'titulo_produto' => $listaProdutos['titulo_produto'],
                    'quantidade' => $quantidade,
                    'preco' => $listaProdutos['preco'],
                    'total' => $total,
                    'codClienteVenda' => $_SESSION['codClienteVenda'],
                    'forma_dePagamento' => $_SESSION['forma_dePagamento'],
                                                                                
                )
            );
        
            
        }
    }