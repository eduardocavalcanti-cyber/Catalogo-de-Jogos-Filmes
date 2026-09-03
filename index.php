<?php
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/Config/config.php';

use Controller\UsuarioController;
use Controller\ItemController;
use Controller\ReservaController;

$p = $_GET['p'] ?? 'inicio';
$uCtrl = new UsuarioController();
$iCtrl = new ItemController();
$rCtrl = new ReservaController();

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $csrf = $_POST['csrf'] ?? '';
    if (!csrf_validar($csrf)) { $_SESSION['flash_erro']='Token inválido.'; redirecionar("index.php?p=$p"); }
    if ($p==='cadastro') {
        $r=$uCtrl->cadastrar($_POST['nome']??'',$_POST['email']??'',$_POST['senha']??'',$_POST['confirma']??'');
        $_SESSION[$r['ok']?'flash_ok':'flash_erro']=$r['msg'];
        redirecionar($r['ok']?'index.php?p=login':'index.php?p=cadastro');
    }
    if ($p==='login') {
        $r=$uCtrl->login($_POST['email']??'',$_POST['senha']??'');
        if($r['ok']) redirecionar('index.php?p=catalogo');
        $_SESSION['flash_erro']=$r['msg']; redirecionar('index.php?p=login');
    }
    if ($p==='reservar') {
        exigir_login();
        $itemId=(int)($_POST['item_id']??0);
        $r=$rCtrl->reservar((int)$_SESSION['usuario']['id'],$itemId);
        $_SESSION[$r['ok']?'flash_ok':'flash_erro']=$r['msg'];
        redirecionar("index.php?p=detalhes&id=$itemId");
    }
    if ($p==='cancelar') {
        exigir_login();
        $r=$rCtrl->cancelar((int)($_POST['reserva_id']??0),(int)$_SESSION['usuario']['id']);
        $_SESSION[$r['ok']?'flash_ok':'flash_erro']=$r['msg'];
        redirecionar('index.php?p=reservas');
    }
    if ($p==='perfil') {
        exigir_login();
        $r=$uCtrl->perfilAtualizar((int)$_SESSION['usuario']['id'],$_POST['nome']??'',$_POST['email']??'',$_POST['nova_senha']??null,$_POST['senha_atual']??null);
        $_SESSION[$r['ok']?'flash_ok':'flash_erro']=$r['msg'];
        redirecionar('index.php?p=perfil');
    }
    if ($p==='novo-item') {
        exigir_login();
        $r=$iCtrl->cadastrar($_POST,$_FILES['imagem']??null);
        $_SESSION[$r['ok']?'flash_ok':'flash_erro']=$r['msg'];
        redirecionar($r['ok']?'index.php?p=catalogo':'index.php?p=novo-item');
    }
}
if ($p==='logout') { session_destroy(); redirecionar('index.php'); }

$viewMap=[
 'inicio'=>'inicio','login'=>'login','cadastro'=>'cadastro','catalogo'=>'catalogo',
 'detalhes'=>'detalhes','reservas'=>'reservas','perfil'=>'perfil','novo-item'=>'novo-item','dashboard'=>'dashboard'
];
$view=$viewMap[$p]??'inicio';
if(in_array($view,['reservas','perfil','novo-item','dashboard']) && !usuario_logado()) redirecionar('index.php?p=login');

ob_start();
include __DIR__."/View/{$view}.php";
$conteudo=ob_get_clean();
include __DIR__.'/View/partials/layout.php';
