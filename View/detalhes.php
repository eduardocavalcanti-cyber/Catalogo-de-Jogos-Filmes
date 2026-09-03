<?php
$id=(int)($_GET['id']??0); $it=$iCtrl->detalhes($id);
if(!$it){ echo '<div class="alert alert-warning">Item não encontrado.</div>'; return; }
$d=$iCtrl->disponiveis($id); $capa=!empty($it['imagem'])?'storage/uploads/'.e($it['imagem']):null;
?>
<a href="index.php?p=catalogo" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Voltar ao catálogo</a>
<div class="row g-4">
<div class="col-md-5"><div class="detail-cover shadow-sm"><?php if($capa):?><img src="<?=e($capa)?>"><?php else:?><?=$it['tipo']==='livro'?'📚':'🎮'?><?php endif;?></div></div>
<div class="col-md-7">
<span class="badge <?=$it['tipo']==='livro'?'badge-livro':'badge-jogo'?> fs-6"><?=e(ucfirst($it['tipo']))?></span>
<span class="badge bg-light text-dark border"><?=e($it['categoria'])?></span>
<h2 class="fw-bold mt-2"><?=e($it['titulo'])?></h2>
<p class="text-muted"><?=e($it['autor'])?> · <?=e($it['ano'])?></p>
<p><?=nl2br(e($it['descricao']))?></p>
<div class="mb-3"><span class="badge <?=$d>1?'badge-disp':($d==1?'badge-pouco':'badge-ind')?> fs-6"><?=$d>0?"🟢 $d disponível(is)":"🔴 Indisponível"?></span> <small class="text-muted ms-2">Total: <?=e($it['quantidade'])?></small></div>
<?php if($d>0): ?>
 <?php if(usuario_logado()): ?>
  <form method="POST" action="index.php?p=reservar"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="item_id" value="<?=$it['id']?>"><button class="btn btn-pri btn-lg"><i class="bi bi-bookmark-plus me-2"></i>Reservar</button></form>
 <?php else: ?><a href="index.php?p=login" class="btn btn-pri btn-lg">Faça login para reservar</a><?php endif; ?>
<?php else: ?><button class="btn btn-secondary btn-lg" disabled>Indisponível</button><?php endif; ?>
</div></div>
