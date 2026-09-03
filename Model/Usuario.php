<?php
namespace Model;
use Config\Conexao;
use PDO;

class Usuario
{
    public function cadastrar(string $nome, string $email, string $senhaHash): bool
    {
        $pdo = Conexao::getInstancia();
        $sql = "INSERT INTO users (nome,email,senha) VALUES (:nome,:email,:senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':senha', $senhaHash, PDO::PARAM_STR);
        return $stmt->execute();
    }
    public function buscarPorEmail(string $email): ?array
    {
        $pdo = Conexao::getInstancia();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email LIMIT 1");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $r = $stmt->fetch();
        return $r ?: null;
    }
    public function buscarPorId(int $id): ?array
    {
        $pdo = Conexao::getInstancia();
        $stmt = $pdo->prepare("SELECT id,nome,email,created_at FROM users WHERE id=:id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetch();
        return $r ?: null;
    }
    public function atualizar(int $id, string $nome, string $email): bool
    {
        $pdo = Conexao::getInstancia();
        $stmt = $pdo->prepare("UPDATE users SET nome=:nome,email=:email WHERE id=:id");
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function atualizarSenha(int $id, string $hash): bool
    {
        $pdo = Conexao::getInstancia();
        $stmt = $pdo->prepare("UPDATE users SET senha=:s WHERE id=:id");
        $stmt->bindValue(':s', $hash, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function buscarSenha(int $id): ?string
    {
        $pdo = Conexao::getInstancia();
        $stmt = $pdo->prepare("SELECT senha FROM users WHERE id=:id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetch();
        return $r['senha'] ?? null;
    }
}
