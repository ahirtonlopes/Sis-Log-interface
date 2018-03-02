<?php

class Conexao{
    public $nomebanco;
    public $usuario;
    public $servidor;
    public $conexao;
    

    protected function __construct($nomebanco, $usuario, $servidor){
        $this->nomebanco = $nomebanco;
        $this->usuario = $usuario;
        $this->servidor = $servidor;
      

        $this->conexao = mysql_connect($this->servidor,$this->usuario)or die($this->erro(mysql_error()));
        mysql_select_db($this->nomebanco)or die($this->erro(mysql_error()));
    }

     public static function getInstance($nomebanco, $usuario, $servidor) {
        static $instance = null;

        if(!isset($instance)) {
	    $instance = new Conexao($nomebanco, $usuario, $servidor);
        }

        return $instance;
     }

    function Erro($erro_valor){
        error_log($erro_valor."\n",3,"erro\erro.log");
    }

    function DisconnectBD(){
        mysql_close($this->conexao);
    }


}
?>
