<?php

Class Aposta{

    public $jogo_times;
    public $jogo_resultados;
    public $jogo_apostas;

    public function setVars($jogo1_resultado, $jogo2_resultado, $jogo3_resultado, $jogo1, $jogo2, $jogo3){
        $this->jogo_resultados = [[0,0,0], [0,0,0], [0,0,0]];
        $this->jogo_apostas = [[0,0,0], [0,0,0], [0,0,0]];
        $this->jogo_times = [['',''],['',''],['','']];

        $this->explodeAndInsertInRes($jogo1_resultado, 0);
        $this->explodeAndInsertInRes($jogo2_resultado, 1);
        $this->explodeAndInsertInRes($jogo3_resultado, 2);
        
        $this->explodeAndInsertInApos($jogo1, 0);
        $this->explodeAndInsertInApos($jogo2, 1);
        $this->explodeAndInsertInApos($jogo3, 2);
    }

    private function explodeAndInsertInRes($string, $pos){
        if($string != null){
            $explode = explode('x', $string);
            $this->jogo_resultados[$pos][0] = $explode[0];
            $this->jogo_resultados[$pos][1] = $explode[1];
        }else{
            $this->jogo_resultados[$pos][0] = 0;
            $this->jogo_resultados[$pos][1] = 0;
        }

        if($this->jogo_resultados[$pos][0] > $this->jogo_resultados[$pos][1]){
            $this->jogo_resultados[$pos][2] = 0;
        }else if($this->jogo_resultados[$pos][1] > $this->jogo_resultados[$pos][0]){
            $this->jogo_resultados[$pos][2] = 1;
        }else{
            $this->jogo_resultados[$pos][2] = 2;
        }
    }

    private function explodeAndInsertInApos($string, $pos){
        if($string != null){
            $explode = explode('x', $string);
            $this->jogo_apostas[$pos][0] = $explode[0];
            $this->jogo_apostas[$pos][1] = $explode[1];
        }else{
            $this->jogo_apostas[$pos][0] = 0;
            $this->jogo_apostas[$pos][1] = 0;
        }

        if($this->jogo_apostas[$pos][0] > $this->jogo_apostas[$pos][1]){
            $this->jogo_apostas[$pos][2] = 0;
        }else if($this->jogo_apostas[$pos][1] > $this->jogo_apostas[$pos][0]){
            $this->jogo_apostas[$pos][2] = 1;
        }else{
            $this->jogo_apostas[$pos][2] = 2;
        }
    }
}