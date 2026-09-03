<div class="row justify-content-center"><div class="col-md-5"><div class="form-card">
<h4 class="fw-bold text-center mb-1">Entrar</h4><p class="text-muted text-center small mb-4">Acesse sua conta</p>
<form method="POST"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<div class="mb-3"><label class="form-label">E-mail</label><input type="email" name="email" class="form-control" required></div>
<div class="mb-3"><label class="form-label">Senha</label><input type="password" name="senha" class="form-control" required></div>
<button class="btn btn-pri w-100">Entrar</button></form>
<p class="text-center mt-3 small">Não tem conta? <a href="index.php?p=cadastro">Cadastre-se</a></p>
</div></div></div>
