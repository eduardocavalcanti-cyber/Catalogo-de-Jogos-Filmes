<?php
use Model\Usuario;
$m=new Usuario(); $dados=$m->buscarPorId((int)$_SESSION['usuario']['id']);
?>
<div class="row justify-content-center"><div class="col-md-7"><div class="form-card">
<h4 class="fw-bold mb-3"><i class="bi bi-person me-2"></i>Meu Perfil</h4>
<p class="text-muted small">Membro desde <?=date('d/m/Y',strtotime($dados['created_at']))?></p>
<form method="POST"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<div class="mb-3"><label class="form-label">Nome</label><input name="nome" class="form-control" value="<?=e($dados['nome'])?>" required></div>
<div class="mb-3"><label class="form-label">E-mail</label><input type="email" name="email" class="form-control" value="<?=e($dados['email'])?>" required></div>
<hr><p class="fw-semibold small">Alterar senha (opcional)</p>
<div class="mb-3"><label class="form-label">Senha atual</label><input type="password" name="senha_atual" class="form-control"></div>
<div class="mb-3"><label class="form-label">Nova senha</label><input type="password" name="nova_senha" class="form-control"></div>
<button class="btn btn-pri w-100">Salvar alterações</button>
</form>
</div></div></div>
