<?php $lista=$rCtrl->minhas((int)$_SESSION['usuario']['id']); ?>
<h4 class="fw-bold mb-3"><i class="bi bi-bookmarks me-2"></i>Minhas Reservas</h4>
<?php if(!$lista): ?><div class="alert alert-light text-center py-5">Você ainda não tem reservas. <a href="index.php?p=catalogo">Explorar catálogo</a></div><?php endif; ?>
<div class="row g-3">
<?php foreach($lista as $r): $capa=!empty($r['imagem'])?'storage/uploads/'.e($r['imagem']):null; ?>
<div class="col-md-6">
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
<div class="d-flex">
<div style="width:110px;min-height:140px;background:linear-gradient(135deg,#e0e7ff,#fce7f3);display:flex;align-items:center;justify-content:center;font-size:2rem;overflow:hidden"><?php if($capa):?><img src="<?=e($capa)?>" style="width:100%;height:100%;object-fit:cover"><?php else:?><?=$r['tipo']==='livro'?'📚':'🎮'?><?php endif;?></div>
<div class="p-3 flex-fill">
<div class="d-flex justify-content-between"><span class="badge <?=$r['tipo']==='livro'?'badge-livro':'badge-jogo'?>"><?=e(ucfirst($r['tipo']))?></span>
<span class="badge <?=$r['status']==='ativa'?'bg-success':($r['status']==='cancelada'?'bg-secondary':'bg-primary')?>"><?=e(ucfirst($r['status']))?></span></div>
<div class="fw-semibold mt-1"><?=e($r['titulo'])?></div>
<small class="text-muted"><?=e($r['autor'])?> · devolução: <?=e($r['data_devolucao'])?></small><br>
<small class="text-muted">Reservado em <?=date('d/m/Y',strtotime($r['data_reserva']))?></small>
<?php if($r['status']==='ativa'): ?>
<form method="POST" action="index.php?p=cancelar" class="mt-2"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="reserva_id" value="<?=$r['id']?>"><button class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Cancelar reserva?')">Cancelar</button></form>
<?php endif; ?>
</div></div></div></div>
<?php endforeach; ?>
</div>
