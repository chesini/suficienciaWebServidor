<?php
namespace App\View;


class ContratoEstagio {
    public function __construct() {
        if(!$_SESSION['logado']) {
            ob_clean();
            header('Status: 401 Unauthorized', false, 401);
            header('Location: /login/sem_permissao');
        }
    }

    public function showLista($lista = []) {
        {
            if(!isset($lista[0]))
                $lista = [$lista];

            $a = "
            <!DOCTYPE html>
    
                <style>
                    table, th, td {
                        border: 1px solid black;
                        border-collapse: collapse;
                        text-align: center;
                    }
                </style>
                <body>
                    <p>
                        <a href=\"/\">Home</a>
                    </p><br/>
                    <header>Lista de Contratos de Estágio</header>
                    <table>
                        <thead>
                            <th>Situação</th>
                            <th>Empresa</th>
                            <th>Estagiário</th>
                            <th>Carga Horária</th>
                            <th>Data Início</th>
                            <th>Data Fim</th>
                            <th>Descrição</th>
                        </thead>
                        <tbody>
            ";
    
            if(count($lista) > 1) {
                foreach($lista as $dadosContrato) {
                    $a .= " <tr> 
                                <td>{$dadosContrato['situacao']}</td>
                                <td>{$dadosContrato['empresa']}</td>
                                <td>{$dadosContrato['estagiario']}</td>
                                <td>{$dadosContrato['cargahoraria']}</td>
                                <td>{$dadosContrato['datainicio']}</td>
                                <td>{$dadosContrato['datafim']}</td>
                                <td>{$dadosContrato['descricao']}</td>
                                <td><button onclick=\"excluirContrato({$dadosContrato['idcontratoestagio']})\">Excluir Contrato</button></td>
                            </tr>";
                }
            }
    
            $a .= "
                        </tbody>
                        
                    </table>
                    
                    <form method=\"post\" action=\"/login/realizar_logout\">
                        <button type=\"submit\">Logout</button>
                    </form>
                </body>
                <script type = \"text/javascript\">
                    function excluirContrato(idcontratoestagio) {
                        console.log(window.href);
                        window.location.href  = \"/contratoestagio/excluir/\" + idcontratoestagio;
                    }
                </script>
            
            </html>";
    
            return $a;
        }
    }

    public function showCadastro() {

        return file_get_contents(__DIR__. '/html/contratoCadastro.html');
    }

}