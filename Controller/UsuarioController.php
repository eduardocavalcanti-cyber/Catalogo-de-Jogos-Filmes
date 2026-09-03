<?php
namespace Controller;
use Model\Usuario;

class UsuarioController
{
    private Usuario $model;
    public function __construct(){ $this->model=new Usuario(); }

    public function cadastrar(string $nome,string $email,string $senha,string $confirma): array
    {
        $nome=trim($nome); $email=trim($email);
        if($nome===''||$email===''||$senha==='') return ['ok'=>false,'msg'=>'Preencha todos os campos.'];
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)) return ['ok'=>false,'msg'=>'E-mail inválido.'];
        if(strlen($senha)<6) return ['ok'=>false,'msg'=>'Senha deve ter ao menos 6 caracteres.'];
        if($senha!==$confirma) return ['ok'=>false,'msg'=>'Senhas não conferem.'];
        if($this->model->buscarPorEmail($email)) return ['ok'=>false,'msg'=>'E-mail já cadastrado.'];
        $hash=password_hash($senha,PASSWORD_DEFAULT);
        $ok=$this->model->cadastrar($nome,$email,$hash);
        return $ok?['ok'=>true,'msg'=>'Conta criada! Faça login.']:['ok'=>false,'msg'=>'Erro ao cadastrar.'];
    }
    public function login(string $email,string $senha): array
    {
        $u=$this->model->buscarPorEmail(trim($email));
        if(!$u || !password_verify($senha,$u['senha'])) return ['ok'=>false,'msg'=>'E-mail ou senha inválidos.'];
        $_SESSION['usuario']=['id'=>(int)$u['id'],'nome'=>$u['nome'],'email'=>$u['email']];
        return ['ok'=>true,'msg'=>'Bem-vindo!'];
    }
    public function logout(): void { session_destroy(); }
    public function perfilAtualizar(int $id,string $nome,string $email,?string $novaSenha,?string $senhaAtual): array
    {
        $nome=trim($nome); $email=trim($email);
        if($nome===''||$email==='') return ['ok'=>false,'msg'=>'Nome e e-mail obrigatórios.'];
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)) return ['ok'=>false,'msg'=>'E-mail inválido.'];
        $atual=$this->model->buscarPorEmail($email);
        if($atual && (int)$atual['id']!==$id) return ['ok'=>false,'msg'=>'E-mail já em uso.'];
        $this->model->atualizar($id,$nome,$email);
        $_SESSION['usuario']['nome']=$nome; $_SESSION['usuario']['email']=$email;
        if($novaSenha){
            if(!$senhaAtual) return ['ok'=>false,'msg'=>'Informe a senha atual.'];
            $hashAtual=$this->model->buscarSenha($id);
            if(!password_verify($senhaAtual,$hashAtual)) return ['ok'=>false,'msg'=>'Senha atual incorreta.'];
            if(strlen($novaSenha)<6) return ['ok'=>false,'msg'=>'Nova senha muito curta.'];
            $this->model->atualizarSenha($id,password_hash($novaSenha,PASSWORD_DEFAULT));
        }
        return ['ok'=>true,'msg'=>'Perfil atualizado!'];
    }
}
