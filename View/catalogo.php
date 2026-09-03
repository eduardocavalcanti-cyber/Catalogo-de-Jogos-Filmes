<?php
$busca=$_GET['busca']??''; $tipo=$_GET['tipo']??''; $disp=$_GET['disp']??'';
$itens=$iCtrl->listar(['busca'=>$busca,'tipo'=>$tipo,'disp'=>$disp]);
?>
<form method="GET" class="search-bar bg-white p-3 rounded-4 mb-4">
<input type="hidden" name="p" value="catalogo">
<div class="row g-2">
<div class="col-md-5"><input name="busca" value="<?=e($busca)?>" class="form-control" placeholder="Buscar por título..."></div>
<div class="col-6 col-md-2"><select name="tipo" class="form-select"><option value="">Todos</option><option value="livro" <?=$tipo==='livro'?'selected':''?>>📚 Livros</option><option value="jogo" <?=$tipo==='jogo'?'selected':''?>>🎮 Jogos</option></select></div>
<div class="col-6 col-md-3"><select name="disp" class="form-select"><option value="">Disponibilidade</option><option value="disponivel" <?=$disp==='disponivel'?'selected':''?>>Disponíveis</option><option value="indisponivel" <?=$disp==='indisponivel'?'selected':''?>>Indisponíveis</option></select></div>
<div class="col-md-2 d-grid"><button class="btn btn-pri">Filtrar</button></div>
</div>
</form>

<div class="d-flex gap-2 mb-3 flex-wrap">
<a href="index.php?p=catalogo" class="btn btn-sm <?=!$tipo?'btn-dark':'btn-outline-secondary'?> rounded-pill">Todos</a>
<a href="index.php?p=catalogo&tipo=livro" class="btn btn-sm <?=$tipo==='livro'?'btn-dark':'btn-outline-secondary'?> rounded-pill">📚 Livros</a>
<a href="index.php?p=catalogo&tipo=jogo" class="btn btn-sm <?=$tipo==='jogo'?'btn-dark':'btn-outline-secondary'?> rounded-pill">🎮 Jogos</a>
</div>

<?php if(!$itens): ?><div class="alert alert-light text-center py-5">Nenhum item encontrado.</div><?php endif; ?>
<div class="row g-3">
<?php foreach($itens as $it): $d=$iCtrl->disponiveis((int)$it['id']); $capa=!empty($it['imagem'])?'storage/uploads/'.e($it['imagem']):null; ?>
<div class="col-6 col-md-4 col-lg-3">
<div class="card card-item h-100">
<div class="cap"><?php if($capa):?><img src="<?=e($capa)?>" alt="capa"><?php else:?><?=$it['tipo']==='livro'?'📚':'🎮'?><?php endif;?></div>
<div class="card-body">
<span class="badge <?=$it['tipo']==='livro'?'badge-livro':'badge-jogo'?>"><?=e(ucfirst($it['tipo']))?></span>
<span class="badge bg-light text-muted border"><?=e($it['categoria'])?></span>
<h6 class="mt-2 mb-1 fw-bold" style="min-height:2.6em"><?=e($it['titulo'])?></h6>
<small class="text-muted d-block"><?=e($it['autor'])?> · <?=e($it['ano'])?></small>
<div class="mt-2"><span class="badge <?=$d>1?'badge-disp':($d==1?'badge-pouco':'badge-ind')?>"><?=$d>0?($d==1?'🟡 1 unidade':'🟢 '.$d.' disp.'): '🔴 Indisponível'?></span></div>
<a href="index.php?p=detalhes&id=<?=$it['id']?>" class="btn btn-outline-primary w-100 mt-3 rounded-3 btn-sm">Ver detalhes</a>
</div></div></div>
<?php endforeach; ?>
</div>
