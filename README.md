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

1. Crie o banco importando `database/schema.sql` no MySQL.
2. Ajuste as variáveis `HIREAZY_DB_HOST`, `HIREAZY_DB_NAME`, `HIREAZY_DB_USER` e `HIREAZY_DB_PASS`, ou use os padrões no `includes/config.php`.
3. Na pasta do projeto, execute: `php -S 0.0.0.0:8080`
4. Abra `http://localhost:8080`.

O hash de seed é para a senha de demonstração `password`.
