<?php
namespace Controller;
use Model\Item;

class ItemController
{
    private Item $model;
    public function __construct(){ $this->model=new Item(); }
    public function listar(array $filtros=[]): array { return $this->model->listar($filtros['busca']??null,$filtros['tipo']??null,$filtros['disp']??null); }
    public function detalhes(int $id): ?array { return $this->model->buscarPorId($id); }
    public function disponiveis(int $id): int { return $this->model->disponiveis($id); }
    public function destaques(): array { return $this->model->destaques(6); }
    public function cadastrar(array $dados, ?array $arquivo): array
    {
        $titulo=trim($dados['titulo']??''); $tipo=$dados['tipo']??''; $desc=trim($dados['descricao']??'');
        $autor=trim($dados['autor']??''); $ano=(int)($dados['ano']??0); $cat=trim($dados['categoria']??''); $qtd=(int)($dados['quantidade']??0);
        if($titulo===''||$tipo===''||$desc===''||$autor===''||$cat==='') return ['ok'=>false,'msg'=>'Preencha todos os campos.'];
        if(!in_array($tipo,['livro','jogo'])) return ['ok'=>false,'msg'=>'Tipo inválido.'];
        if($ano<1000||$ano>2030) return ['ok'=>false,'msg'=>'Ano inválido.'];
        if($qtd<0) return ['ok'=>false,'msg'=>'Quantidade inválida.'];
        $imagem=null;
        if($arquivo && $arquivo['error']!==UPLOAD_ERR_NO_FILE){
            if($arquivo['error']!==UPLOAD_ERR_OK) return ['ok'=>false,'msg'=>'Erro no upload.'];
            if($arquivo['size']>2*1024*1024) return ['ok'=>false,'msg'=>'Imagem até 2MB.'];
            $finfo=new \finfo(FILEINFO_MIME_TYPE); $mime=$finfo->file($arquivo['tmp_name']);
            $map=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
            if(!isset($map[$mime])) return ['ok'=>false,'msg'=>'Formato permitido: JPG, PNG, WEBP.'];
            $ext=$map[$mime]; $nome=uniqid('capa_',true).'.'.$ext;
            $dir=__DIR__.'/../storage/uploads/'; if(!is_dir($dir)) mkdir($dir,0755,true);
            if(!move_uploaded_file($arquivo['tmp_name'],$dir.$nome)) return ['ok'=>false,'msg'=>'Falha ao salvar imagem.'];
            $imagem=$nome;
        }
        $ok=$this->model->cadastrar(['titulo'=>$titulo,'tipo'=>$tipo,'descricao'=>$desc,'autor'=>$autor,'ano'=>$ano,'categoria'=>$cat,'imagem'=>$imagem,'quantidade'=>$qtd]);
        return $ok?['ok'=>true,'msg'=>'Item cadastrado!']:['ok'=>false,'msg'=>'Erro ao cadastrar.'];
    }
}
