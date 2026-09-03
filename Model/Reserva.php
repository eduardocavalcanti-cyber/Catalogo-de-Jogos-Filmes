<?php
namespace Model;
use Config\Conexao;
use PDO;

class Reserva
{
    public function criar(int $userId, int $itemId): array
    {
        $pdo = Conexao::getInstancia();
        try {
            $pdo->beginTransaction();
            $st = $pdo->prepare("SELECT quantidade FROM items WHERE id=:id FOR UPDATE");
            $st->bindValue(':id', $itemId, PDO::PARAM_INT); $st->execute();
            $q = $st->fetchColumn();
            if ($q === false) throw new \Exception("Item não encontrado.");
            $st2 = $pdo->prepare("SELECT COUNT(*) FROM reservas WHERE item_id=:id AND status='ativa'");
            $st2->bindValue(':id', $itemId, PDO::PARAM_INT); $st2->execute();
            $ativas = (int)$st2->fetchColumn();
            if ($ativas >= (int)$q) throw new \Exception("Item indisponível.");
            $st3 = $pdo->prepare("SELECT COUNT(*) FROM reservas WHERE user_id=:uid AND item_id=:iid AND status='ativa'");
            $st3->bindValue(':uid', $userId, PDO::PARAM_INT); $st3->bindValue(':iid', $itemId, PDO::PARAM_INT); $st3->execute();
            if ((int)$st3->fetchColumn() > 0) throw new \Exception("Você já possui reserva ativa para este item.");
            $dev = date('Y-m-d', strtotime('+7 days'));
            $ins = $pdo->prepare("INSERT INTO reservas (user_id,item_id,data_devolucao,status) VALUES (:uid,:iid,:dev,'ativa')");
            $ins->bindValue(':uid', $userId, PDO::PARAM_INT);
            $ins->bindValue(':iid', $itemId, PDO::PARAM_INT);
            $ins->bindValue(':dev', $dev);
            $ins->execute();
            $pdo->commit();
            return ['ok' => true, 'msg' => 'Reserva realizada! Retire em até 7 dias.'];
        } catch (\Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            return ['ok' => false, 'msg' => $e->getMessage()];
        }
    }
    public function listarPorUsuario(int $uid): array
    {
        $pdo = Conexao::getInstancia();
        $st = $pdo->prepare("SELECT r.*, i.titulo,i.tipo,i.autor,i.imagem,i.categoria FROM reservas r JOIN items i ON i.id=r.item_id WHERE r.user_id=:uid ORDER BY r.data_reserva DESC");
        $st->bindValue(':uid', $uid, PDO::PARAM_INT); $st->execute(); return $st->fetchAll();
    }
    public function cancelar(int $reservaId, int $uid): array
    {
        $pdo = Conexao::getInstancia();
        $st = $pdo->prepare("SELECT * FROM reservas WHERE id=:id AND user_id=:uid");
        $st->bindValue(':id', $reservaId, PDO::PARAM_INT); $st->bindValue(':uid', $uid, PDO::PARAM_INT); $st->execute();
        $r = $st->fetch(); if (!$r) return ['ok'=>false,'msg'=>'Reserva não encontrada.'];
        if ($r['status'] !== 'ativa') return ['ok'=>false,'msg'=>'Só é possível cancelar reservas ativas.'];
        $up = $pdo->prepare("UPDATE reservas SET status='cancelada' WHERE id=:id");
        $up->bindValue(':id', $reservaId, PDO::PARAM_INT); $up->execute();
        return ['ok'=>true,'msg'=>'Reserva cancelada.'];
    }
    public function resumoUsuario(int $uid): array
    {
        $pdo = Conexao::getInstancia();
        $st = $pdo->prepare("SELECT status,COUNT(*) c FROM reservas WHERE user_id=:uid GROUP BY status");
        $st->bindValue(':uid', $uid, PDO::PARAM_INT); $st->execute();
        $res = ['ativa'=>0,'cancelada'=>0,'concluida'=>0];
        foreach ($st->fetchAll() as $row) $res[$row['status']]=(int)$row['c'];
        $ult = $pdo->prepare("SELECT r.*,i.titulo FROM reservas r JOIN items i ON i.id=r.item_id WHERE r.user_id=:uid ORDER BY r.data_reserva DESC LIMIT 1");
        $ult->bindValue(':uid', $uid, PDO::PARAM_INT); $ult->execute(); $res['ultima']=$ult->fetch()?:null;
        return $res;
    }
}
