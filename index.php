<?php

require_once 'includes/config.php';

$providers = [];

if ($pdo) {
    try {
        $providers = $pdo
            ->query("SELECT * FROM users WHERE role='provider' ORDER BY rating DESC LIMIT 6")
            ->fetchAll();
    } catch (Throwable $e) {
    }
}

if (!$providers) {
    $providers = [
        [
            'name' => 'Ana Martins',
            'profession' => 'Designer de interiores',
            'city' => 'São Paulo',
            'bio' => 'Transformo espaços em lugares para viver melhor.',
            'rating' => '4.9',
            'hourly_rate' => '120'
        ],
        [
            'name' => 'Rafael Lima',
            'profession' => 'Eletricista residencial',
            'city' => 'Rio de Janeiro',
            'bio' => 'Instalação, manutenção e pequenos reparos com segurança.',
            'rating' => '4.8',
            'hourly_rate' => '90'
        ],
        [
            'name' => 'Carla Souza',
            'profession' => 'Fotógrafa',
            'city' => 'Belo Horizonte',
            'bio' => 'Retratos naturais para marcas, eventos e histórias reais.',
            'rating' => '5.0',
            'hourly_rate' => '180'
        ]
    ];
}

$title = 'Hireazy — encontre quem faz';

require 'includes/header.php';

?>

<section class="hero">
    <div>
        <div class="eyebrow">Contrate com confiança</div>

        <h1>O serviço que você precisa. A pessoa certa para fazer.</h1>

        <p>
            Encontre profissionais avaliados para resolver o que importa —
            da reforma da casa ao cuidado com seu negócio.
        </p>

        <div class="hero-actions">
            <a class="btn btn-dark" href="#profissionais">
                Encontrar um profissional
            </a>

            <a class="btn btn-light" href="register.php?role=provider">
                Quero prestar serviços
            </a>
        </div>
    </div>

    <div class="hero-card">
        <span class="mini-label">HIREAZY / HOJE</span>

        <h3>Mais tempo para o que realmente importa.</h3>

        <div>
            <span class="service-pill">Reformas</span>
            <span class="service-pill">Design</span>
            <span class="service-pill">Aulas</span>
            <span class="service-pill">Beleza</span>
        </div>
    </div>
</section>

<section class="section" id="profissionais">
    <div class="section-head">
        <div>
            <div class="eyebrow">Escolha sem complicação</div>
            <h2>Profissionais que fazem acontecer.</h2>
        </div>

        <p>
            Busque por serviço ou cidade. Compare perfis, avaliações e
            valores antes de solicitar.
        </p>
    </div>

    <input
        class="searchbar"
        id="professional-search"
        type="search"
        placeholder="O que você precisa? Ex.: eletricista, fotógrafo..."
    >

    <div class="cards">
        <?php foreach ($providers as $p): ?>
            <article
                class="provider-card"
                data-profession="<?= e($p['profession']) ?>"
                data-city="<?= e($p['city']) ?>"
            >
                <div class="avatar">
                    <?= e(strtoupper(substr($p['name'], 0, 1))) ?>
                </div>

                <h3><?= e($p['name']) ?></h3>

                <div class="eyebrow">
                    <?= e($p['profession']) ?>
                </div>

                <p><?= e($p['bio']) ?></p>

                <div class="meta">
                    <span>
                        R$ <?= number_format((float) $p['hourly_rate'], 0, ',', '.') ?>/hora
                    </span>

                    <span class="rating">
                        ★ <?= e($p['rating']) ?>
                    </span>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section" id="como-funciona">
    <div class="section-head">
        <div>
            <div class="eyebrow">Do pedido à entrega</div>
            <h2>Feito para ser simples.</h2>
        </div>
    </div>

    <div class="steps">
        <div class="step">
            <span class="step-number">01 / ENCONTRE</span>
            <h3>Descreva o que precisa</h3>
            <p>
                Conte os detalhes do seu serviço e encontre especialistas
                perto de você.
            </p>
        </div>

        <div class="step">
            <span class="step-number">02 / COMBINE</span>
            <h3>Escolha seu profissional</h3>
            <p>
                Veja avaliações, experiência e valores. Você decide com
                quem trabalhar.
            </p>
        </div>

        <div class="step">
            <span class="step-number">03 / RESOLVA</span>
            <h3>Acompanhe tudo por aqui</h3>
            <p>
                Converse, acompanhe o pedido e avalie a experiência ao final.
            </p>
        </div>
    </div>
</section>

<section class="cta">
    <h2>Seu próximo trabalho pode começar agora.</h2>

    <a class="btn btn-dark" href="register.php?role=provider">
        Criar perfil profissional
    </a>
</section>

<?php require 'includes/footer.php'; ?>