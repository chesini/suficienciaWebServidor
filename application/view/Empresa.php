<?php
namespace App\View;


class Empresa {
    public function __construct() {
        if(!$_SESSION['logado']) {
            ob_clean();
            header('Status: 401 Unauthorized', false, 401);
            header('Location: /login/sem_permissao');
        }
    }

    public function showLista($empresas) {
        if(!isset($empresas[0]))
            $empresas = [$empresas];

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
                <table>
                    <caption>Lista de Empresa</caption>
                    <thead>
                        <th>ID Empresa</th>
                        <th>Nome Empresa</th>
                        <th>Contratos Vigentes</th>
                        <th>Contratos Encerrados</th>
                        <th>Responsavel Empresa</th>
                        <th>Telefone</th>
                        <th>Email</th>
                    </thead>
                    <tbody>
        ";

        if(count($empresas) > 0) {
            foreach($empresas as $dadosEmpresa) {
                $a .= " <tr> 
                            <td>{$dadosEmpresa['idempresa']}</td>
                            <td onclick=\"contratosEmpresa({$dadosEmpresa['idempresa']});\" >{$dadosEmpresa['nomeempresa']}</td>
                            <td>{$dadosEmpresa['qtdvigente']}</td>
                            <td>{$dadosEmpresa['qtdencerrado']}</td>
                            <td>{$dadosEmpresa['responsavelempresa']}</td>
                            <td>{$dadosEmpresa['telefone']}</td>
                            <td>{$dadosEmpresa['email']}</td>
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
                function contratosEmpresa(idempresa) {
                    console.log(window.href);
                    window.location.href  = \"/contratoestagio/lista/\" + idempresa;
                }
            </script>
        </html>";

        return $a;
    }

    public function showCadastro() {

        return file_get_contents(__DIR__. '/html/empresaCadastro.html');
    }

}
