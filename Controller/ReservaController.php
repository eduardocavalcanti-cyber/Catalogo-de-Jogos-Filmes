<?php
namespace Controller;
use Model\Reserva;
class ReservaController {
    private Reserva $model;
    public function __construct(){ $this->model=new Reserva(); }
    public function reservar(int $uid,int $itemId): array { return $this->model->criar($uid,$itemId); }
    public function minhas(int $uid): array { return $this->model->listarPorUsuario($uid); }
    public function cancelar(int $reservaId,int $uid): array { return $this->model->cancelar($reservaId,$uid); }
    public function resumo(int $uid): array { return $this->model->resumoUsuario($uid); }
}
