<?php

require_once 'includes/config.php';
require_once 'includes/functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($pdo) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user'] = $user;
            redirect('dashboard.php');
        }
    }

    $errors[] = 'E-mail ou senha incorretos.';
}

$title = 'Entrar — Hireazy';

require 'includes/header.php';

?>

<section class="form-page">
    <div class="eyebrow">Bom ter você de volta</div>

    <h1>Entre na sua conta.</h1>

    <form class="form-card" method="post">
        <div class="field">
            <label>E-mail</label>
            <input type="email" name="email" required autofocus>
        </div>

        <div class="field">
            <label>Senha</label>
            <input type="password" name="password" required>
        </div>

        <?php if ($errors): ?>
            <p style="color: #a52525; font-size: 14px">
                <?= e($errors[0]) ?>
            </p>
        <?php endif; ?>

        <button
            class="btn btn-dark"
            type="submit"
            style="width: 100%"
        >
            Entrar
        </button>

        <p
            class="empty"
            style="text-align: center; margin-bottom: 0"
        >
            Ainda não tem conta?
            <a href="register.php"><u>Crie agora</u></a>
        </p>
    </form>
</section>

<?php require 'includes/footer.php'; ?>