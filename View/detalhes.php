<?php

$id = (int) ($_GET['id'] ?? 0);
$item = $iCtrl->detalhes($id);

if (!$item) {
    echo '<div class="alert alert-warning">Item não encontrado.</div>';
    return;
}

$disponiveis = $iCtrl->disponiveis($id);

$capa = !empty($item['imagem'])
    ? 'storage/uploads/' . e($item['imagem'])
    : null;

$tipoClasse = $item['tipo'] === 'livro'
    ? 'badge-livro'
    : 'badge-jogo';

$disponibilidadeClasse = $disponiveis > 1
    ? 'badge-disp'
    : ($disponiveis === 1 ? 'badge-pouco' : 'badge-ind');

$iconeTipo = $item['tipo'] === 'livro'
    ? '📚'
    : '🎮';

?>

<a
    href="index.php?p=catalogo"
    class="btn btn-sm btn-outline-secondary mb-3"
>
    <i class="bi bi-arrow-left"></i>
    Voltar ao catálogo
</a>

<div class="row g-4">

    <div class="col-md-5">
        <div class="detail-cover shadow-sm">

            <?php if ($capa): ?>

                <img
                    src="<?= e($capa) ?>"
                    alt="<?= e($item['titulo']) ?>"
                >

            <?php else: ?>

                <?= $iconeTipo ?>

            <?php endif; ?>

        </div>
    </div>

    <div class="col-md-7">

        <div class="mb-2">

            <span class="badge <?= $tipoClasse ?> fs-6">
                <?= e(ucfirst($item['tipo'])) ?>
            </span>

            <span class="badge bg-light text-dark border">
                <?= e($item['categoria']) ?>
            </span>

        </div>

        <h2 class="fw-bold mt-2">
            <?= e($item['titulo']) ?>
        </h2>

        <p class="text-muted">
            <?= e($item['autor']) ?> · <?= e($item['ano']) ?>
        </p>

        <p>
            <?= nl2br(e($item['descricao'])) ?>
        </p>

        <div class="mb-3">

            <span class="badge <?= $disponibilidadeClasse ?> fs-6">
                <?= $disponiveis > 0
                    ? "🟢 {$disponiveis} disponível(is)"
                    : '🔴 Indisponível'
                ?>
            </span>

            <small class="text-muted ms-2">
                Total: <?= e($item['quantidade']) ?>
            </small>

        </div>

        <?php if ($disponiveis > 0): ?>

            <?php if (usuario_logado()): ?>

                <form
                    method="POST"
                    action="index.php?p=reservar"
                >
                    <input
                        type="hidden"
                        name="csrf"
                        value="<?= e(csrf_token()) ?>"
                    >

                    <input
                        type="hidden"
                        name="item_id"
                        value="<?= $item['id'] ?>"
                    >

                    <button
                        type="submit"
                        class="btn btn-pri btn-lg"
                    >
                        <i class="bi bi-bookmark-plus me-2"></i>
                        Reservar
                    </button>
                </form>

            <?php else: ?>

                <a
                    href="index.php?p=login"
                    class="btn btn-pri btn-lg"
                >
                    Faça login para reservar
                </a>

            <?php endif; ?>

        <?php else: ?>

            <button
                type="button"
                class="btn btn-secondary btn-lg"
                disabled
            >
                Indisponível
            </button>

        <?php endif; ?>

    </div>

</div>
