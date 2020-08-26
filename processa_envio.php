<?php

    class Mensagem {
        private $para = null;
        private $assunto = null;
        private $mensagem = null;

        public function __get($atr){
            return $this->$atr;
        }

        public function __set($atr, $val){
            $this->$atr = $val;
        }

        public function mensagemValida(){
            if (empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
                return false;
            }

            return true;
        }
    }

    $mensagem = new Mensagem();

    //recuperando os valores dos inputs passando atributo e valor
    $mensagem->__set('para', $_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

    //print_r($mensagem);

    if($mensagem->mensagemValida()){
        echo 'Mensagem válida';
    } else {
        echo 'Mensagem não válida';
    }

?>