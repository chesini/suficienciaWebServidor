<?php

namespace Routes;

use App\Controller\Login;
use App\Controller\Empresa;
use App\Controller\Estagiario;
use App\Controller\ContratoEstagio;
use App\View\Home;
use Exception;

abstract class RouteSwitch {
    protected function login($parametros = NULL) {
        try {
            $autenticacao = new Login();

            if(is_array($parametros)) {
                if(count($parametros) <= 0) {
                    $autenticacao->show();
                    exit;
                }

                if(count($parametros) != 1)
                    $this->badRequest();
                else {
                    if($parametros[0] == "realizar_login") {
                        $usuario = filter_input(INPUT_POST, 'usuario');
                        $senha = filter_input(INPUT_POST, 'senha');
                        $sucesso = $autenticacao->realizarLogin($usuario, $senha);
                        if($sucesso){
                            ob_clean();
                            header('Status: 200 OK', true, 200);
                            header('Location: /');
                        } else {
                            ob_clean();
                            header('Status: 401 Unauthorized', true, 401);
                            header('Location: /login/rejeitado');
                        }
                        exit;

                    } else if($parametros[0] == "realizar_logout") {
                        if($autenticacao->realizarLogout()) {
                            ob_clean();
                            header('Status: 200 OK', true, 200);
                            header('Location: /login/desconectado');
                        }

                    } else if($parametros[0] == "desconectado") {
                        $autenticacao->show();

                    } else if($parametros[0] == "rejeitado") {
                        $autenticacao->show();

                    } else if($parametros[0] == "sem_permissao") {
                        $autenticacao->show();

                    } else {
                        ob_clean();
                        header('Location: /login');
                    }
                }
            } else {
                $autenticacao->show();
            }
            exit;

        } catch (Exception $exc) {
            $this->internalError();
        }
    }

    protected function home($parametros = NULL) {
        try {
            $inicio = new Home();
            echo $inicio->show();
        } catch(Exception $exc) {

        }
    }

    protected function empresa($parametros = NULL) {
        try {
            $empresaController = new Empresa();

            if(is_array($parametros)) {
                if(count($parametros) <= 0) {
                    $empresaController->showLista();
                    exit;
                }

                if(count($parametros) > 2)
                    $this->badRequest();
                else {
                    if($parametros[0] == "lista") {
                        
                        

                    } else if($parametros[0] == "cadastro") {
                        if (!isset($parametros[1])) {
                            $empresaController->showCadastro();

                        } else if($parametros[1] == "novo") {
                            $nomeEmpresa = filter_input(INPUT_POST, 'nomeempresa');
                            $responsavelEmpresa = filter_input(INPUT_POST, 'responsavelempresa');
                            $telefone = filter_input(INPUT_POST, 'telefone');
                            $email = filter_input(INPUT_POST, 'email');

                            $param = array(
                                'nomeempresa' => $nomeEmpresa, 
                                'responsavelempresa' => $responsavelEmpresa, 
                                'telefone' => $telefone,
                                'email' => $email
                            );
                            $sucesso = $empresaController->cadastrarEmpresa($param);
                            if($sucesso) {
                                ob_clean();
                                header('Location: /empresa/cadastro/sucesso');
                            } else {
                                ob_clean();
                                header('Location: /empresa/cadastro/falha');
                            }

                        } else if($parametros[1] == "sucesso") {
                            $empresaController->showCadastro();
                        } else if($parametros[1] == "falha") {
                            $empresaController->showCadastro();
                        }
                        
                    } else {
                        ob_clean();
                        header('Location: /empresa');
                    }
                }
            } else {
                $empresaController->showLista();
            }
        } catch (Exception $exc) {

        }

    }

    protected function estagiario($parametros = NULL) {
        require __DIR__ . '\\..\\application\\controller\\Estagiario.php';
    }

    protected function contrato($parametros = NULL) {
        require __DIR__ . '\\..\\application\\controller\\ContratoEstagio.php';
    }

    public function __call($name, $arguments) {
        $this->badRequest();
    }

    public function badRequest() {
        ob_clean();
        http_response_code(400);
        require __DIR__ . '\\..\\application\\view\\html\\bad-request.html';
    }

    public function notFound() {
        ob_clean();
        http_response_code(404);
        require __DIR__ . '\\..\\application\\view\\html\\not-found.html';
    }

    public function internalError() {
        ob_clean();
        http_response_code(500);
        require __DIR__ . '\\..\\application\\view\\html\\internal-error.html';
    }
}
