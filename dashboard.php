<?php

require_once 'includes/config.php';
require_once 'includes/functions.php';

require_login();

$user = current_user();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user['role'] === 'client') {
    $provider = (int) ($_POST['provider_id'] ?? 0);
    $titleReq = trim($_POST['title'] ?? '');
    $desc = trim($_POST['description'] ?? '');

    if ($pdo && $provider && $titleReq && $desc) {
        $s = $pdo->prepare('INSERT INTO service_requests(client_id, provider_id, title, description) VALUES(?, ?, ?, ?)');
        $s->execute([$user['id'], $provider, $titleReq, $desc]);

        flash('success', 'Pedido enviado! O profissional poderá responder em breve.');
        redirect('dashboard.php');
    } else {
        $errors[] = 'Preencha todos os campos do pedido.';
    }
}

$providers = [];
$requests = [];

if ($pdo) {
    if ($user['role'] === 'client') {
        $providers = $pdo->query("SELECT * FROM users WHERE role = 'provider' ORDER BY rating DESC")->fetchAll();

        $s = $pdo->prepare('
            SELECT r.*, u.name provider_name
            FROM service_requests r
            JOIN users u ON u.id = r.provider_id
            WHERE r.client_id = ?
            ORDER BY r.created_at DESC
        ');

        $s->execute([$user['id']]);
        $requests = $s->fetchAll();
    } else {
        $s = $pdo->prepare('
            SELECT r.*, u.name client_name
            FROM service_requests r
            JOIN users u ON u.id = r.client_id
            WHERE r.provider_id = ?
            ORDER BY r.created_at DESC
        ');

        $s->execute([$user['id']]);
        $requests = $s->fetchAll();
    }
}

$title = 'Meu painel — Hireazy';

require 'includes/header.php';
?>

<section class="dashboard">
    <div class="eyebrow">Área exclusiva</div>

    <h1 style="font-size: 52px">
        Olá, <?= e(explode(' ', $user['name'])[0]) ?>.
    </h1>

    <p class="empty">
        <?= $user['role'] === 'client'
            ? 'Encontre o próximo profissional para tirar seu plano do papel.'
            : 'Veja novas oportunidades e acompanhe seus serviços.'
        ?>
    </p>

    <?php if ($errors): ?>
        <div class="flash error" style="position: static; margin: 18px 0">
            <?= e($errors[0]) ?>
        </div>
    <?php endif; ?>

    <div class="dash-grid" style="margin-top: 35px">
        <div class="panel">
            <h3>
                <?= $user['role'] === 'client'
                    ? 'Profissionais em destaque'
                    : 'Solicitações recebidas'
                ?>
            </h3>

            <?php if ($user['role'] === 'client'): ?>

                <?php foreach ($providers as $p): ?>
                    <div class="list-item">
                        <div>
                            <strong><?= e($p['name']) ?></strong><br>
                            <span class="empty">
                                <?= e($p['profession']) ?> · ★ <?= e($p['rating']) ?>
                            </span>
                        </div>

                        <a class="btn btn-small btn-light" href="#request-<?= $p['id'] ?>">
                            Solicitar
                        </a>
                    </div>
                <?php endforeach; ?>

                <?php if (!$providers): ?>
                    <p class="empty">Importe o schema para carregar profissionais.</p>
                <?php endif; ?>

            <?php else: ?>

                <?php foreach ($requests as $r): ?>
                    <div class="list-item">
                        <div>
                            <strong><?= e($r['title']) ?></strong><br>
                            <span class="empty">De <?= e($r['client_name']) ?></span>
                        </div>

                        <span class="badge"><?= e($r['status']) ?></span>
                    </div>
                <?php endforeach; ?>

                <?php if (!$requests): ?>
                    <p class="empty">Você ainda não recebeu solicitações.</p>
                <?php endif; ?>

            <?php endif; ?>
        </div>

        <div class="panel">
            <h3>Seu perfil</h3>

            <p>
                <strong><?= e($user['name']) ?></strong><br>
                <?= e($user['email']) ?><br>
                <?= e($user['city'] ?: 'Cidade não informada') ?>
            </p>

            <?php if ($user['role'] === 'provider'): ?>
                <p class="empty">
                    <?= e($user['profession']) ?><br>
                    <?= e($user['bio']) ?>
                </p>
            <?php else: ?>
                <p class="empty">
                    Você está no modo contratante. Envie um pedido para começar.
                </p>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($user['role'] === 'client' && $providers): ?>
        <h2 style="font-size: 32px; margin-top: 65px">Faça uma solicitação</h2>

        <div class="cards">
            <?php foreach ($providers as $p): ?>
                <form class="provider-card" id="request-<?= $p['id'] ?>" method="post">
                    <input type="hidden" name="provider_id" value="<?= $p['id'] ?>">

                    <h3><?= e($p['name']) ?></h3>

                    <div class="eyebrow"><?= e($p['profession']) ?></div>

                    <div class="field">
                        <label>Título do serviço</label>
                        <input name="title" required placeholder="Ex.: Preciso de uma instalação">
                    </div>

                    <div class="field">
                        <label>Detalhes</label>
                        <textarea name="description" required placeholder="Explique o que você precisa..."></textarea>
                    </div>

                    <button class="btn btn-dark" type="submit">
                        Enviar pedido
                    </button>
                </form>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require 'includes/footer.php'; ?>