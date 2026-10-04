<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function e(?string $value): string
{
    return htmlspecialchars(
        $value ?? '',
        ENT_QUOTES,
        'UTF-8'
    );
}

function is_logged(): bool
{
    return isset($_SESSION['user']);
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(24));
    }

    return $_SESSION['csrf'];
}

function verify_csrf(): bool
{
    return hash_equals(
        $_SESSION['csrf'] ?? '',
        $_POST['csrf'] ?? ''
    );
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = [$type, $message];
}

function get_flash(): ?array
{
    $f = $_SESSION['flash'] ?? null;

    unset($_SESSION['flash']);

    return $f;
}

function require_login(): void
{
    if (!is_logged()) {
        flash(
            'error',
            'Entre na sua conta para continuar.'
        );

        redirect('login.php');
    }
}