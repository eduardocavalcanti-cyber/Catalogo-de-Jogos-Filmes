<div class="row justify-content-center"><div class="col-md-8"><div class="form-card">
<h4 class="fw-bold mb-3">Cadastrar Livro / Jogo</h4><p class="text-muted small">Demonstração do requisito POST — dados salvos via PDO</p>
<form method="POST" enctype="multipart/form-data"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<div class="row g-3">
<div class="col-md-8"><label class="form-label">Título</label><input name="titulo" class="form-control" required></div>
<div class="col-md-4"><label class="form-label">Tipo</label><select name="tipo" class="form-select" required><option value="livro">📚 Livro</option><option value="jogo">🎮 Jogo</option></select></div>
<div class="col-12"><label class="form-label">Descrição</label><textarea name="descricao" rows="3" class="form-control" required></textarea></div>
<div class="col-md-6"><label class="form-label">Autor / Desenvolvedor</label><input name="autor" class="form-control" required></div>
<div class="col-md-3"><label class="form-label">Ano</label><input name="ano" type="number" min="1000" max="2030" class="form-control" required></div>
<div class="col-md-3"><label class="form-label">Quantidade</label><input name="quantidade" type="number" min="0" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">Categoria</label><input name="categoria" placeholder="Fantasia, RPG, Romance..." class="form-control" required></div>
<div class="col-md-6"><label class="form-label">Capa (JPG/PNG/WEBP até 2MB)</label><input type="file" name="imagem" accept="image/*" class="form-control"></div>
</div>
<button class="btn btn-pri w-100 mt-4">Cadastrar item</button>
</form>
</div></div></div>
