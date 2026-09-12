<?php
<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="form-card">

            <h4 class="fw-bold mb-3">
                Cadastrar Livro / Jogo
            </h4>

            <p class="text-muted small">
                Demonstração do requisito POST — dados salvos via PDO
            </p>

            <form
                method="POST"
                enctype="multipart/form-data"
            >

                <input
                    type="hidden"
                    name="csrf"
                    value="<?= e(csrf_token()) ?>"
                >

                <div class="row g-3">

                    <div class="col-md-8">
                        <label class="form-label">
                            Título
                        </label>

                        <input
                            type="text"
                            name="titulo"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Tipo
                        </label>

                        <select
                            name="tipo"
                            class="form-select"
                            required
                        >
                            <option value="livro">
                                📚 Livro
                            </option>

                            <option value="jogo">
                                🎮 Jogo
                            </option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">
                            Descrição
                        </label>

                        <textarea
                            name="descricao"
                            rows="3"
                            class="form-control"
                            required
                        ></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Autor / Desenvolvedor
                        </label>

                        <input
                            type="text"
                            name="autor"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            Ano
                        </label>

                        <input
                            type="number"
                            name="ano"
                            min="1000"
                            max="2030"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            Quantidade
                        </label>

                        <input
                            type="number"
                            name="quantidade"
                            min="0"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Categoria
                        </label>

                        <input
                            type="text"
                            name="categoria"
                            placeholder="Fantasia, RPG, Romance..."
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Capa
                        </label>

                        <input
                            type="file"
                            name="imagem"
                            accept="image/*"
                            class="form-control"
                        >
                    </div>

                </div>

                <button
                    type="submit"
                    class="btn btn-pri w-100 mt-4"
                >
                    Cadastrar item
                </button>

            </form>

        </div>

    </div>

</div>
