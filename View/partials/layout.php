<?php $u=usuario_logado(); $flashOk=$_SESSION['flash_ok']??null; $flashErro=$_SESSION['flash_erro']??null; unset($_SESSION['flash_ok'],$_SESSION['flash_erro']); ?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Catálogo — Livros & Jogos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
<link href="public/css/style.css" rel="stylesheet"></head><body>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
<div class="container"><a class="navbar-brand" href="index.php"><i class="bi bi-collection me-2"></i>CATÁLOGO</a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="nav">
<ul class="navbar-nav me-auto">
<li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
<li class="nav-item"><a class="nav-link" href="index.php?p=catalogo">Catálogo</a></li>
<?php if($u): ?><li class="nav-item"><a class="nav-link" href="index.php?p=reservas">Minhas Reservas</a></li><?php endif; ?>
</ul>
<ul class="navbar-nav ms-auto align-items-lg-center">
<?php if($u): ?>
<li class="nav-item"><a class="nav-link" href="index.php?p=dashboard"><i class="bi bi-person-circle me-1"></i><?=e($u['nome'])?></a></li>
<li class="nav-item"><a class="nav-link" href="index.php?p=novo-item">+ Item</a></li>
<li class="nav-item"><a class="btn btn-sm btn-light ms-2" href="index.php?p=logout">Sair</a></li>
<?php else: ?>
<li class="nav-item"><a class="nav-link" href="index.php?p=login">Entrar</a></li>
<li class="nav-item"><a class="btn btn-pri btn-sm ms-2" href="index.php?p=cadastro">Criar conta</a></li>
<?php endif; ?>
</ul></div></div></nav>
<main class="container py-4">
<?php if($flashOk): ?><div class="alert alert-success alert-dismissible fade show"><?=e($flashOk)?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
<?php if($flashErro): ?><div class="alert alert-danger alert-dismissible fade show"><?=e($flashErro)?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
<?= $conteudo ?? '' ?>
</main>
<footer class="text-center text-muted py-4 small">Catálogo & Reserva — Projeto acadêmico MVC · PHP 8.3 · PDO · MySQL</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script></body></html>
