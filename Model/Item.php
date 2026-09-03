<?php
namespace Model;
use Config\Conexao;
use PDO;
class Item {
    public function listar(?string $busca=null, ?string $tipo=null, ?string $disp=null): array {
        $pdo=Conexao::getInstancia();
        $sql="SELECT * FROM items WHERE 1=1"; $p=[];
        if($busca){ $sql.=" AND titulo LIKE :busca"; $p[':busca']="%$busca%"; }
        if($tipo && in_array($tipo,['livro','jogo'])){ $sql.=" AND tipo=:tipo"; $p[':tipo']=$tipo; }
        if($disp==='disponivel'){ $sql.=" AND quantidade > (SELECT COUNT(*) FROM reservas r WHERE r.item_id=items.id AND r.status='ativa')"; }
        elseif($disp==='indisponivel'){ $sql.=" AND quantidade <= (SELECT COUNT(*) FROM reservas r WHERE r.item_id=items.id AND r.status='ativa')"; }
        $sql.=" ORDER BY created_at DESC";
        $stmt=$pdo->prepare($sql);
        foreach($p as $k=>$v) $stmt->bindValue($k,$v,PDO::PARAM_STR);
        $stmt->execute(); return $stmt->fetchAll();
    }
    public function buscarPorId(int $id): ?array {
        $pdo=Conexao::getInstancia();
        $stmt=$pdo->prepare("SELECT * FROM items WHERE id=:id");
        $stmt->bindValue(':id',$id,PDO::PARAM_INT); $stmt->execute();
        $r=$stmt->fetch(); return $r?:null;
    }
    public function disponiveis(int $itemId): int {
        $pdo=Conexao::getInstancia();
        $stmt=$pdo->prepare("SELECT quantidade FROM items WHERE id=:id");
        $stmt->bindValue(':id',$itemId,PDO::PARAM_INT); $stmt->execute();
        $q=(int)($stmt->fetchColumn()??0);
        $stmt2=$pdo->prepare("SELECT COUNT(*) FROM reservas WHERE item_id=:id AND status='ativa'");
        $stmt2->bindValue(':id',$itemId,PDO::PARAM_INT); $stmt2->execute();
        $ativas=(int)$stmt2->fetchColumn();
        return max(0,$q-$ativas);
    }
    public function destaques(int $lim=4): array {
        $pdo=Conexao::getInstancia();
        $stmt=$pdo->query("SELECT * FROM items ORDER BY created_at DESC LIMIT $lim");
        return $stmt->fetchAll();
    }
    public function cadastrar(array $d): bool {
        $pdo=Conexao::getInstancia();
        $stmt=$pdo->prepare("INSERT INTO items (titulo,tipo,descricao,autor,ano,categoria,imagem,quantidade) VALUES (:t,:tp,:d,:a,:ano,:cat,:img,:q)");
        $stmt->bindValue(':t',$d['titulo'],PDO::PARAM_STR);
        $stmt->bindValue(':tp',$d['tipo'],PDO::PARAM_STR);
        $stmt->bindValue(':d',$d['descricao'],PDO::PARAM_STR);
        $stmt->bindValue(':a',$d['autor'],PDO::PARAM_STR);
        $stmt->bindValue(':ano',$d['ano'],PDO::PARAM_INT);
        $stmt->bindValue(':cat',$d['categoria'],PDO::PARAM_STR);
        $stmt->bindValue(':img',$d['imagem'],PDO::PARAM_STR);
        $stmt->bindValue(':q',$d['quantidade'],PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function total(): int {
        return (int)Conexao::getInstancia()->query("SELECT COUNT(*) FROM items")->fetchColumn();
    }
}
