<?php

require_once __DIR__ . '/functions.php';
$user = current_user();
$flash = get_flash();

?>

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title><?= e($title ?? 'Hireazy') ?></title>
    <link
        rel="stylesheet"
        href="assets/style.css"
    >
</head>

<body>
    <header class="topbar">
        <a
            class="brand"
            href="index.php"
            aria-label="Hireazy"
        >
            <img
                src="assets/hireazy-logo.png"
                alt="Hireazy"
            >
        </a>
        <nav class="nav-links">
            <a href="index.php#como-funciona">
                Como funciona
            </a>
            <a href="index.php#profissionais">
                Profissionais
            </a>

            <?php if ($user): ?>

                <a href="dashboard.php">
                    Meu painel
                </a>
                <a
                    class="nav-user"
                    href="dashboard.php"
                >
                    Olá, <?= e(explode(' ', $user['name'])[0]) ?>
                </a>
                <a
                    href="logout.php"
                    class="link-muted"
                >
                    Sair
                </a>

            <?php else: ?>

                <a
                    href="login.php"
                    class="link-muted"
                >
                    Entrar
                </a>
                <a
                    href="register.php"
                    class="btn btn-dark btn-small"
                >
                    Criar conta
                </a>

            <?php endif; ?>

        </nav>
        <button
            class="menu-toggle"
            aria-label="Abrir menu"
        >
            ☰
        </button>
    </header>

    <?php if ($flash): ?>

        <div class="flash <?= e($flash[0]) ?>">
            <?= e($flash[1]) ?>
        </div>

    <?php endif; ?>
    <main>