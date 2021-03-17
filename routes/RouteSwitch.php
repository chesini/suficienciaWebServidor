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
                    $empresaController->showLista($empresaController->getLista());
                    exit;
                }

                if(count($parametros) > 2)
                    $this->badRequest();
                else {
                    if($parametros[0] == "lista") {
                        if(!isset($parametros[1]))
                            $empresaController->showLista($empresaController->getLista());
                        else if($parametros[1] == "busca") {
                            $listaEmpresas = $empresaController->getLista();
                            echo utf8_decode(json_encode($listaEmpresas));
                            exit(200);
                        }

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
                            header('Status: 412 Precondition Failed', true, 412);
                            $empresaController->showCadastro();
                        }
                        
                    } else {
                        ob_clean();
                        header('Location: /empresa');
                    }
                }
            } else {
                $empresaController->showLista($empresaController->getLista());
            }
        } catch (Exception $exc) {
            $this->internalError();
        }

    }

    protected function estagiario($parametros = NULL) {
        try {
            $estagiarioController = new Estagiario();

            if(is_array($parametros)) {
                if(count($parametros) > 2)
                    $this->badRequest();
                else {
                    if($parametros[0] == "cadastro") {
                        if(!isset($parametros[1]))
                            $estagiarioController->show();

                        else if($parametros[1] == "novo") {
                            $nomeEstagiario = filter_input(INPUT_POST, 'nomeestagiario');
                            $regAcademico = filter_input(INPUT_POST, 'regacademico');
                            $telefone = filter_input(INPUT_POST, 'telefone');
                            $email = filter_input(INPUT_POST, 'email');

                            $param = array(
                                'nomeestagiario' => $nomeEstagiario, 
                                'regacademico' => $regAcademico, 
                                'telefone' => $telefone,
                                'email' => $email
                            );
                            $sucesso = $estagiarioController->cadastrarEstagiario($param);
                            if($sucesso) {
                                ob_clean();
                                header('Location: /estagiario/cadastro/sucesso');
                            } else {
                                ob_clean();
                                header('Location: /estagiario/cadastro/falha');
                            }

                        } else if($parametros[1] == "sucesso") {
                            $estagiarioController->show();
                            
                        } else if($parametros[1] == "falha") {
                            header('Status: 412 Precondition Failed', true, 412);
                            $estagiarioController->show();
                        }

                    } else {
                        ob_clean();
                        header('Location: /');
                    }
                }
            } else {
                $this->badRequest();
            }
        } catch (Exception $exc) {
            $this->internalError();
        }
    }

    protected function contratoestagio($parametros = NULL) {
        try {
            $contratoController = new ContratoEstagio();

            if(is_array($parametros)) {
                if(count($parametros) > 2)
                    $this->badRequest();
                else {
                    if($parametros[0] == "cadastro") {
                        if(!isset($parametros[1]))
                            $contratoController->showCadastro();

                        else if($parametros[1] == "novo") {
                            $idEmpresa = filter_input(INPUT_POST, 'idempresa');
                            $regAcademico = filter_input(INPUT_POST, 'regacademico');
                            $dataInicio = filter_input(INPUT_POST, 'datainicio');
                            $dataFim = filter_input(INPUT_POST, 'datafim');
                            $cargaHoraria = filter_input(INPUT_POST, 'cargahoraria');
                            $descricao = filter_input(INPUT_POST, 'descricao');

                            $param = array(
                                'idempresa' => $idEmpresa, 
                                'regacademico' => $regAcademico, 
                                'datainicio' => $dataInicio,
                                'datafim' => $dataFim,
                                'cargahoraria' => $cargaHoraria,
                                'descricao' => $descricao
                            );
                            $sucesso = $contratoController->cadastrarContrato($param);
                            if($sucesso) {
                                ob_clean();
                                header('Location: /contratoestagio/cadastro/sucesso');
                            } else {
                                ob_clean();
                                header('Location: /contratoestagio/cadastro/falha');
                            }

                        } else if($parametros[1] == "sucesso") {
                            $contratoController->showCadastro();
                            
                        } else if($parametros[1] == "falha") {
                            header('Status: 412 Precondition Failed', true, 412);
                            $contratoController->showCadastro();
                        }

                    } else if($parametros[0] == "lista") {
                        if(!isset($parametros[1]))
                            $contratoController->showLista();
                        else if(is_int($parametros[1])) {
                            $contratoController->showLista($parametros[1]);
                        } else {
                            $contratoController->showLista();
                        }
                    } else if($parametros[0] == "excluir") {
                        if(!isset($parametros[1]))
                            $this->badRequest();
                        else if(intval($parametros[1]) > 0) {
                            if($contratoController->excluirContrato($parametros[1])) {
                                ob_clean();
                                header('Location: /contratoestagio/lista');
                            }
                        }
                    } else {
                        ob_clean();
                        header('Location: /contratoestagio/lista');
                    }
                }
            } else {
                $this->badRequest();
            }
        } catch (Exception $exc) {
            $this->internalError();
        }
    }

    public function __call($name, $arguments) {
        $this->badRequest();
    }

    public function badRequest() {
        ob_clean();
        http_response_code(400);
        require __DIR__ . '\\..\\application\\view\\html\\bad-request.html';
        exit;
    }

    public function notFound() {
        ob_clean();
        http_response_code(404);
        require __DIR__ . '\\..\\application\\view\\html\\not-found.html';
        exit;
    }

    public function internalError() {
        ob_clean();
        http_response_code(500);
        require __DIR__ . '\\..\\application\\view\\html\\internal-error.html';
        exit;
    }
}
