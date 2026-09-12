<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="form-card">
            <h4 class="fw-bold text-center mb-1">
                Criar conta
            </h4>

            <p class="text-muted text-center small mb-4">
                Leva 30 segundos
            </p>

            <form method="POST">
                <input
                    type="hidden"
                    name="csrf"
                    value="<?= e(csrf_token()) ?>"
                >

                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input
                        name="nome"
                        class="form-control"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha (mín. 6)</label>
                    <input
                        type="password"
                        name="senha"
                        class="form-control"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmar senha</label>
                    <input
                        type="password"
                        name="confirma"
                        class="form-control"
                        required
                    >
                </div>

                <button class="btn btn-pri w-100">
                    Criar conta
                </button>
            </form>

            <p class="text-center mt-3 small">
                Já tem conta?
                <a href="index.php?p=login">Entrar</a>
            </p>
        </div>
    </div>
</div>
