<?php
use Model\Item;
$m=new Item(); $destaques=$m->destaques(6);
function capa($it){ if(!empty($it['imagem'])) return 'storage/uploads/'.e($it['imagem']); return null; }
?>
<div class="hero p-4 p-md-5 mb-4 d-flex flex-column flex-md-row align-items-center gap-4">
<div class="flex-fill">
<h1 class="display-6">Sua biblioteca de <span style="color:#a5b4fc">livros</span> e <span style="color:#f9a8d4">jogos</span></h1>
<p class="opacity-75 mt-3">Crie sua conta, explore o catálogo e reserve em segundos. Projeto acadêmico simples, rápido e responsivo.</p>
<div class="d-flex gap-2 mt-4 flex-wrap">
<?php if(!usuario_logado()): ?>
<a href="index.php?p=cadastro" class="btn btn-light btn-lg rounded-3 fw-semibold">Criar conta</a>
<a href="index.php?p=login" class="btn btn-outline-light btn-lg rounded-3">Entrar</a>
<?php else: ?>
<a href="index.php?p=catalogo" class="btn btn-light btn-lg rounded-3 fw-semibold">Explorar catálogo</a>
<?php endif; ?>
</div>
</div>
<div class="d-none d-md-flex gap-2">
<div class="bg-white text-dark rounded-4 p-3 text-center" style="width:130px"><div style="font-size:2rem">📚</div><small class="fw-semibold">Livros</small></div>
<div class="bg-white text-dark rounded-4 p-3 text-center" style="width:130px"><div style="font-size:2rem">🎮</div><small class="fw-semibold">Jogos</small></div>
</div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
<h4 class="fw-bold m-0">Destaques</h4><a href="index.php?p=catalogo" class="btn btn-sm btn-outline-primary rounded-pill">Ver catálogo <i class="bi bi-arrow-right"></i></a>
</div>
<div class="row g-3">
<?php foreach($destaques as $it): $disp=$m->disponiveis((int)$it['id']); ?>
<div class="col-6 col-md-4 col-lg-2">
<div class="card card-item h-100">
<div class="cap"><?php $c=capa($it); if($c):?><img src="<?=e($c)?>" alt="capa"><?php else:?><?=$it['tipo']==='livro'?'📚':'🎮'?><?php endif;?></div>
<div class="card-body p-3">
<span class="badge <?=$it['tipo']==='livro'?'badge-livro':'badge-jogo'?> mb-1"><?=e(ucfirst($it['tipo']))?></span>
<div class="fw-semibold small text-truncate"><?=e($it['titulo'])?></div>
<small class="text-muted"><?=e($it['autor'])?> · <?=e($it['ano'])?></small>
<div class="mt-1"><span class="badge <?=$disp>1?'badge-disp':($disp==1?'badge-pouco':'badge-ind')?>"><?=$disp>0?"🟢 $disp disp.":"🔴 Indisponível"?></span></div>
</div></div></div>
<?php endforeach; ?>
</div>
