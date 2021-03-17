1. Para execução no SO Windows:
  - Com o XAMPP e o Git instalados na máquina, acesse o diretório htdocs com um terminal
  - Faça o clone do repositório:
    ```bash
    >git clone https://github.com/chesini/suficienciaWebServidor
    ```
  - Acesse o projeto pela URL: http://localhost/suficienciaWebServidor

2. Para a criação da Base de Dados no MySQL via CLI:
```sql
CREATE DATABASE IF NOT EXISTS estagio 
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

USE estagio;

DROP TABLE IF EXISTS estagio.empresa;
CREATE TABLE estagio.empresa ( 
    idempresa SERIAL NOT NULL , 
    nomeempresa TEXT NOT NULL , 
    responsavelempresa TEXT NOT NULL , 
    telefone TEXT NOT NULL , 
    email TEXT NOT NULL , 
    PRIMARY KEY (idempresa)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS estagio.estagiario;
CREATE TABLE estagio.estagiario ( 
    idestagiario SERIAL NOT NULL , 
    nomeestagiario TEXT NOT NULL , 
    regacademico INT UNSIGNED NOT NULL , 
    email TEXT NOT NULL , 
    telefone INT UNSIGNED NOT NULL , 
    PRIMARY KEY (idestagiario)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS estagio.contratoestagio;
CREATE TABLE estagio.contratoestagio ( 
    idcontratoestagio SERIAL NOT NULL , 
    idestagiario INT NOT NULL , 
    idempresa INT NOT NULL , 
    datainicio DATE NOT NULL , 
    datafim DATE NOT NULL , 
    cargahoraria INT NOT NULL , 
    descricao TEXT , 
    idlogin INT NOT NULL,
    PRIMARY KEY (idcontratoestagio)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS estagio.login;
CREATE TABLE estagio.login ( 
    idlogin SERIAL NOT NULL , 
    login TEXT NOT NULL , 
    senha TEXT NOT NULL ,
    nomeresponsavel TEXT NOT NULL ,
    descricao TEXT NOT NULL , 
    PRIMARY KEY (idlogin)
) ENGINE = InnoDB;
```

3. Usuários e senhas cadastrados para teste:
  - leandrochesi@hotmail.com -> 1234
  - adm@estagio.com.br -> abcde