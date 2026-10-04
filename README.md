# Hireazy

MVP de marketplace de serviços inspirado em GetNinjas, iFood e Uber, construído somente com **HTML, CSS, JavaScript, PHP e MySQL**.

## O que foi implementado

- Landing page responsiva com identidade preto/branco e verde ácido como cor proprietária.
- Logo Hireazy fornecido pelo usuário, com fundo bege removido e transparência aplicada.
- Busca client-side de profissionais por profissão ou cidade.
- Cadastro como contratante ou prestador.
- Login com `password_hash`, `password_verify`, PDO e prepared statements.
- Painel do contratante com solicitação de serviço.
- Painel do prestador com solicitações recebidas.
- Schema MySQL com dados demonstrativos.
- A pasta `Hireazy-legacy` preserva os arquivos enviados no ZIP original.

## Rodar localmente

### Usando XAMPP

1. Instale o [XAMPP](https://www.apachefriends.org/).
2. Coloque a pasta `Hireazy` dentro de `C:\xampp\htdocs\`.
3. Abra o XAMPP e inicie o **Apache** e o **MySQL**.
4. Crie o banco de dados importando `database/schema.sql` no MySQL/phpMyAdmin.
5. Ajuste as variáveis `HIREAZY_DB_HOST`, `HIREAZY_DB_NAME`, `HIREAZY_DB_USER` e `HIREAZY_DB_PASS` em `includes/config.php`, se necessário.
6. Acesse:

`http://localhost/Hireazy`

O hash de seed utiliza `password` como senha de demonstração.


O hash de seed é para a senha de demonstração `password`.
