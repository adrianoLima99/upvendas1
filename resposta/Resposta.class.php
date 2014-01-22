 <?php


class Resposta {
    private $id;
    private $resposta;
    private $conn;
    function __construct() {
        $this->conn = new Connection();
    }
   function adicionar($resposta,$descricao){
       $data=  date("Y-m-d");
       $hora=date("H:m:s");
       $sqlResp=$this->conn->exec("INSERT INTO respostaautomatica(resposta,descricao,aprovado,data_cadastro,hora_cadastro,usuario_cadastro) VALUES
                                 ('$resposta','$descricao',1,'$data','$hora',$_SESSION[func_id])");
               
       if($sqlResp){
             echo "<script type='text/javascript'>alert('Resposta criada com sucesso')
                  location.href='?pg=listaResposta';
                    </script>";
       }
   }
   function listaAtivas(){
       if($_SESSION["tipo"]==0){
           $empresa="";
       }else{
           $empresa="AND F.empresa_id=$_SESSION[empresaId]";
       }
       $sql=$this->conn->query("SELECT R.*,F.id AS func_id,F.empresa_id FROM respostaautomatica AS R INNER JOIN funcionario AS F   ON R.usuario_cadastro=F.id
                                WHERE R.ativo=0 AND R.aprovado=0 $empresa");
        if($sql->rowCount()){
           return $sql;
       } else{
           return "";
       }
   }
   function listaNaoAtivas(){
       if($_SESSION["tipo"]==0){
           $empresa="";
       }else{
           $empresa="AND F.empresa_id=$_SESSION[empresaId]";
       }
       $sql=$this->conn->query("SELECT R.*,F.id AS func_id,F.empresa_id FROM respostaautomatica AS R INNER JOIN funcionario AS F   ON R.usuario_cadastro=F.id
                                WHERE R.ativo=0 AND R.aprovado=1 $empresa ");
       if($sql->rowCount()){
           return $sql;
       } else{
           return "";
       }
       
   }
   function excluir($id){
       $sql=$this->conn->query("DELETE FROM respostaautomatica WHERE id=$id");
        if($sql){
            $sqlL=$this->conn->query("SELECT id FROM acompanhamento WHERE resposta_id=$id");
            if($sqlL->rowCount()){
                $this->conn->exec("UPDATE acompanhamento SET resposta_id=0 WHERE id=$id");
            }
             echo "<script type='text/javascript'>
                 alert('Resposta excluida com sucesso')
                  location.href='?pg=listaResposta';
                    </script>";
       }
   }
   function ativar($id){

       $sql=$this->conn->exec("UPDATE respostaautomatica SET aprovado=0 WHERE id=$id");
       if($sql){
             echo "<script type='text/javascript'>
                 alert('Resposta ativada com sucesso')
                  location.href='?pg=listaResposta';
                    </script>";
       }
   }
   function atualizar($id,$descricao,$resposta){
       $sql=$this->conn->exec("UPDATE respostaautomatica SET resposta='$resposta',descricao='$descricao' WHERE id=$id");
       if($sql){
             echo "<script type='text/javascript'>
                 alert('Resposta atualizada com sucesso')
                  location.href='?pg=listaResposta';
                    </script>";
       }
   }
   function selectResposta() {
        if($_SESSION["tipo"]==0){
           $empresa="";
       }else{
           $empresa="AND F.empresa_id=$_SESSION[empresaId]";
       }
        $sql = "SELECT R.*,F.id AS func_id,F.empresa_id FROM respostaautomatica AS R INNER JOIN funcionario AS F   ON R.usuario_cadastro=F.id
                                WHERE R.ativo=0 AND R.aprovado=1 $empresa ";

        $lista = $this->conn->query($sql);
        while ($l = $lista->fetch(PDO::FETCH_OBJ)) {
            $this->id[] = $l->id;
            $this->resposta[] = $l->resposta;
        }
    }
    function getId() {
        return $this->id;
    }

    function getResposta() {
        return $this->resposta;
    }
 
   

}

?>
