# Sistema web com cadastro e login de usuários em PHP
## Descrição
- Sistema web simples com tela de cadastro de usuário, tela de login, tela de edição de dados e tela de boas-vindas.
- Dados são validados no front e backend e são salvos em uma base de dados.
- Segurança de páginas aplicada.

## Linguagens, frameworks, ferramentas e sistemas utilizados
- [PHP 8.2.7 OOP Syntax](https://www.php.net/manual/en/language.oop5.php)
- [Apache 2.4.57-1](https://httpd.apache.org/)
- [Bootstrap 5.2.3](https://getbootstrap.com/docs/5.3/getting-started/introduction/)
- [MariaDB 10.11.4](https://mariadb.org/documentation/)
- [Arch Linux](https://archlinux.org/)

## Pré-requisitos
- [PHP](https://www.php.net/downloads.php)
- [Apache](https://httpd.apache.org/download.cgi)
- [MySQL](https://dev.mysql.com/downloads/) ou [MariaDB](https://mariadb.org/download/)
- [phpMyAdmin](https://www.phpmyadmin.net/downloads/)

## Instalação (localhost)
No terminal clone o projeto:
```
$ git clone https://github.com/zapsys/sistema-web-php-simples.git
```
- Usuários Windows:
    - Instale o XAMPP ou outro pacote com PHP, Apache, phpMyAdmin e MySQL
    - Crie a sua base de dados via `phpMyAdmin`
    - Substitua o nome `DB_SERVER` por `localhost` e preencha as informações do usuário, nome e senha da base de dados no arquivo `config.php`. *No windows o usuário é geralmente **root** e a senha é ''*
    - Copie a pasta do projeto para a pasta `htdocs` do `xampp`
    - Inicie os serviços do `Apache` e `MySQL`
    - Acesse no browser o endereço ```localhost/sistema-web-php-simples```

- Usuários Linux:
    - Instale o PHP, Apache, phpMyAdmin e MariaDB 
    - Crie a sua base de dados via `phpMyAdmin`
    - Substitua o nome `DB_SERVER` por `localhost` e preencha as informações do usuário, nome e senha da base de dados no arquivo `config.php`.
    - Copie a pasta do projeto para a pasta `http` do servidor do `Apache` ou outra que tenha configurado no arquivo `httpd.conf`. 
    - Inicie os serviços do `Apache` e `MySQL`
    - Acesse no browser o endereço ```localhost/sistema-web-php-simples```

# Demo
[sistema-web-php-simples](https://exemplos.zapwebsites.com.br/)

## Erros e dificuldades de instalação
Para esses casos se deve abrir um [issue](https://github.com/zapsys/sistema-web-php-simples/issues)

## Dúvidas ou sugestões
Caso tenha alguma dúvida ou sugestão sinta-se a vontade para me contactar e contribuir.

## Licença
[MIT](LICENSE.md)