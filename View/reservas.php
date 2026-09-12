<?php

$usuarioId = (int) $_SESSION['usuario']['id'];

$lista = $rCtrl->minhas($usuarioId);

?>

<h4 class="fw-bold mb-3">
    <i class="bi bi-bookmarks me-2"></i>
    Minhas Reservas
</h4>

<?php if (!$lista): ?>

    <div class="alert alert-light text-center py-5">
        Você ainda não tem reservas.
        <a href="index.php?p=catalogo">
            Explorar catálogo
        </a>
    </div>

<?php endif; ?>

<div class="row g-3">

    <?php foreach ($lista as $reserva): ?>

        <?php
        $capa = !empty($reserva['imagem'])
            ? 'storage/uploads/' . e($reserva['imagem'])
            : null;

        $tipoClasse = $reserva['tipo'] === 'livro'
            ? 'badge-livro'
            : 'badge-jogo';

        $statusClasse = $reserva['status'] === 'ativa'
            ? 'bg-success'
            : ($reserva['status'] === 'cancelada'
                ? 'bg-secondary'
                : 'bg-primary');

        $iconeTipo = $reserva['tipo'] === 'livro'
            ? '📚'
            : '🎮';
        ?>

        <div class="col-md-6">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                <div class="d-flex">

                    <div
                        style="
                            width: 110px;
                            min-height: 140px;
                            background: linear-gradient(135deg, #e0e7ff, #fce7f3);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 2rem;
                            overflow: hidden;
                        "
                    >

                        <?php if ($capa): ?>

                            <img
                                src="<?= e($capa) ?>"
                                alt="<?= e($reserva['titulo']) ?>"
                                style="
                                    width: 100%;
                                    height: 100%;
                                    object-fit: cover;
                                "
                            >

                        <?php else: ?>

                            <?= $iconeTipo ?>

                        <?php endif; ?>

                    </div>

                    <div class="p-3 flex-fill">

                        <div class="d-flex justify-content-between">

                            <span class="badge <?= $tipoClasse ?>">
                                <?= e(ucfirst($reserva['tipo'])) ?>
                            </span>

                            <span class="badge <?= $statusClasse ?>">
                                <?= e(ucfirst($reserva['status'])) ?>
                            </span>

                        </div>

                        <div class="fw-semibold mt-1">
                            <?= e($reserva['titulo']) ?>
                        </div>

                        <small class="text-muted">
                            <?= e($reserva['autor']) ?>
                            ·
                            devolução:
                            <?= e($reserva['data_devolucao']) ?>
                        </small>

                        <br>

                        <small class="text-muted">
                            Reservado em
                            <?= date('d/m/Y', strtotime($reserva['data_reserva'])) ?>
                        </small>

                        <?php if ($reserva['status'] === 'ativa'): ?>

                            <form
                                method="POST"
                                action="index.php?p=cancelar"
                                class="mt-2"
                            >

                                <input
                                    type="hidden"
                                    name="csrf"
                                    value="<?= e(csrf_token()) ?>"
                                >

                                <input
                                    type="hidden"
                                    name="reserva_id"
                                    value="<?= $reserva['id'] ?>"
                                >

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-outline-danger rounded-pill"
                                    onclick="return confirm('Cancelar reserva?')"
                                >
                                    Cancelar
                                </button>

                            </form>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

</div>
