<?php

require_once 'includes/config.php';
require_once 'includes/functions.php';

$role = ($_GET['role'] ?? $_POST['role'] ?? 'client') === 'provider'
    ? 'provider'
    : 'client';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $city = trim($_POST['city'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $profession = trim($_POST['profession'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $rate = $_POST['hourly_rate'] ?? null;

    if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $errors[] = 'Preencha nome, e-mail válido e uma senha com pelo menos 6 caracteres.';
    }

    if ($role === 'provider' && !$profession) {
        $errors[] = 'Informe sua profissão.';
    }

    if (!$pdo) {
        $errors[] = 'Banco de dados indisponível. Importe database/schema.sql e configure suas credenciais.';
    }

    if (!$errors) {
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO users
                (name, email, password_hash, phone, city, role, profession, bio, hourly_rate)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );

            $stmt->execute([
                $name,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $phone,
                $city,
                $role,
                $profession,
                $bio,
                $rate ?: null
            ]);

            flash('success', 'Conta criada. Agora entre para continuar.');
            redirect('login.php');
        } catch (Throwable $e) {
            $errors[] = 'Este e-mail já está cadastrado ou não foi possível concluir.';
        }
    }
}

$title = 'Criar conta — Hireazy';

require 'includes/header.php';

?>

<section class="form-page">
    <div class="eyebrow">Comece em poucos minutos</div>

    <h1>
        <?= $role === 'provider'
            ? 'Mostre o que você sabe fazer.'
            : 'Encontre a ajuda certa.'
        ?>
    </h1>

    <p class="empty">
        Crie seu perfil gratuito e faça parte da comunidade Hireazy.
    </p>

    <?php if ($errors): ?>
        <div
            class="flash error"
            style="position: static; margin: 18px 0"
        >
            <?= e(implode(' ', $errors)) ?>
        </div>
    <?php endif; ?>

    <form class="form-card" method="post">
        <input
            type="hidden"
            name="csrf"
            value="<?= csrf_token() ?>"
        >

        <input
            type="hidden"
            name="role"
            value="<?= e($role) ?>"
        >

        <div class="radio-row">
            <label>
                <input
                    type="radio"
                    name="role_choice"
                    <?= $role === 'client' ? 'checked' : '' ?>
                    onchange="location.href='register.php?role=client'"
                >
                Quero contratar
            </label>

            <label>
                <input
                    type="radio"
                    name="role_choice"
                    <?= $role === 'provider' ? 'checked' : '' ?>
                    onchange="location.href='register.php?role=provider'"
                >
                Quero trabalhar
            </label>
        </div>

        <div class="field">
            <label>Nome completo</label>
            <input
                name="name"
                required
                value="<?= e($_POST['name'] ?? '') ?>"
            >
        </div>

        <div class="field">
            <label>E-mail</label>
            <input
                type="email"
                name="email"
                required
                value="<?= e($_POST['email'] ?? '') ?>"
            >
        </div>

        <div class="field">
            <label>Senha</label>

            <div class="password-wrap">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    minlength="6"
                >

                <button
                    type="button"
                    data-password-toggle="#password"
                >
                    Mostrar
                </button>
            </div>
        </div>

        <div class="field">
            <label>Cidade</label>
            <input
                name="city"
                value="<?= e($_POST['city'] ?? '') ?>"
                placeholder="Ex.: São Paulo"
            >
        </div>

        <?php if ($role === 'provider'): ?>

            <div class="field">
                <label>Profissão</label>
                <input
                    name="profession"
                    required
                    value="<?= e($_POST['profession'] ?? '') ?>"
                    placeholder="Ex.: Professor de inglês"
                >
            </div>

            <div class="field">
                <label>Conte um pouco sobre seu trabalho</label>

                <textarea
                    name="bio"
                    placeholder="Experiência, diferenciais e tipos de serviço..."
                ><?= e($_POST['bio'] ?? '') ?></textarea>
            </div>

            <div class="field">
                <label>Valor médio por hora (R$)</label>

                <input
                    type="number"
                    min="0"
                    step="0.01"
                    name="hourly_rate"
                    value="<?= e($_POST['hourly_rate'] ?? '') ?>"
                >
            </div>

        <?php endif; ?>

        <button
            class="btn btn-dark"
            type="submit"
            style="width: 100%"
        >
            Criar minha conta
        </button>
    </form>
</section>

<?php require 'includes/footer.php'; ?>