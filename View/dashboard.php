<?php $res=$rCtrl->resumo((int)$_SESSION['usuario']['id']); $u=$_SESSION['usuario']; ?>
<h4>Olá, <?=e($u['nome'])?>! 👋</h4><p class="text-muted">Bem-vindo ao Catálogo</p>
<div class="row g-3 mb-4">
<div class="col-6 col-md-3"><div class="card stats-card p-3 text-center"><div class="fs-3">📖</div><div class="fw-bold fs-4"><?=$res['ativa']?></div><small class="text-muted">Reservas ativas</small></div></div>
<div class="col-6 col-md-3"><div class="card stats-card p-3 text-center"><div class="fs-3">✅</div><div class="fw-bold fs-4"><?=$res['concluida']?></div><small class="text-muted">Concluídas</small></div></div>
<div class="col-6 col-md-3"><div class="card stats-card p-3 text-center"><div class="fs-3">↩️</div><div class="fw-bold fs-4"><?=$res['cancelada']?></div><small class="text-muted">Canceladas</small></div></div>
<div class="col-6 col-md-3"><div class="card stats-card p-3 text-center"><div class="fs-3">🎯</div><div class="fw-bold fs-4"><?= $res['ultima'] ? e($res['ultima']['titulo']) : '—' ?></div><small class="text-muted">Última reserva</small></div></div>
</div>
<div class="d-flex gap-2 flex-wrap">
<a href="index.php?p=catalogo" class="btn btn-pri">Explorar catálogo</a>
<a href="index.php?p=reservas" class="btn btn-outline-primary">Minhas reservas</a>
<a href="index.php?p=perfil" class="btn btn-outline-secondary">Meu perfil</a>
</div>
