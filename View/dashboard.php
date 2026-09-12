<?php

$usuario = $_SESSION['usuario'];
$usuarioId = (int) $usuario['id'];

$resumo = $rCtrl->resumo($usuarioId);

?>

<h4>
    Olá, <?= e($usuario['nome']) ?>! 👋
</h4>

<p class="text-muted">
    Bem-vindo ao Catálogo
</p>

<div class="row g-3 mb-4">

    <div class="col-6 col-md-3">
        <div class="card stats-card p-3 text-center">
            <div class="fs-3">📖</div>

            <div class="fw-bold fs-4">
                <?= $resumo['ativa'] ?>
            </div>

            <small class="text-muted">
                Reservas ativas
            </small>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card stats-card p-3 text-center">
            <div class="fs-3">✅</div>

            <div class="fw-bold fs-4">
                <?= $resumo['concluida'] ?>
            </div>

            <small class="text-muted">
                Concluídas
            </small>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card stats-card p-3 text-center">
            <div class="fs-3">↩️</div>

            <div class="fw-bold fs-4">
                <?= $resumo['cancelada'] ?>
            </div>

            <small class="text-muted">
                Canceladas
            </small>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card stats-card p-3 text-center">
            <div class="fs-3">🎯</div>

            <div class="fw-bold fs-4">
                <?= $resumo['ultima'] ? e($resumo['ultima']['titulo']) : '—' ?>
            </div>

            <small class="text-muted">
                Última reserva
            </small>
        </div>
    </div>

</div>

<div class="d-flex gap-2 flex-wrap">

    <a
        href="index.php?p=catalogo"
        class="btn btn-pri"
    >
        Explorar catálogo
    </a>

    <a
        href="index.php?p=reservas"
        class="btn btn-outline-primary"
    >
        Minhas reservas
    </a>

    <a
        href="index.php?p=perfil"
        class="btn btn-outline-secondary"
    >
        Meu perfil
    </a>

</div>
