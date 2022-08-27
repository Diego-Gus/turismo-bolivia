<?php 

    function formatearFecha($fecha){
        return date('d M, Y, g:i a', strtotime($fecha));
    }

    function textoCorto($text, $chars = 70){
        $text = $text."";
        $text = substr($text, 0 , $chars);
        $text = substr($text, 0 , strrpos($text, ' '));
        $text = $text."...";

        return $text;
    }

?>