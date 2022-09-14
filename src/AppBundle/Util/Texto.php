<?php

namespace AppBundle\Util;

/**
 * Description of Texto
 *
 * @author emi88
 */
class Texto {

    /**
     * Palabras ignorados por la funcion format
     * @var type 
     */
    private static $ignorados = array(
        'de', 'la', 'y', 'en', 'con'
    );
    
    private static $reemplazos = array(
        'Á' => 'á',
        'É' => 'é',
        'Í' => 'í',
        'Ó' => 'ó',
        'Ú' => 'ú',
        ' i ' => ' I ',
        ' ii ' => ' II ',
    );

    /**
     * Transforma una frase al formato ucwords pero teniendo en cuenta las preposiciones de, en, la, etc.
     * 
     * @param type $frase
     * @return string
     */
    public static function ucWordsCustom($frase) {

        //reemplazo de palabras con acento:
        $aux = str_replace(
                array_keys(self::$reemplazos), 
                array_values(self::$reemplazos), 
                mb_strtolower($frase));

        $partes = explode(' ', strtolower($aux));
        $end = end($partes);

        $nueva_frase = '';
        foreach ($partes as $palabra) {
            if (!in_array($palabra, self::$ignorados)) {
                $nueva_frase .= ucfirst($palabra);
            }else{
                $nueva_frase .= $palabra;
            }

            if($end != $palabra){
                // si no es la ultima, añadir un espacio
                $nueva_frase .= ' ';
            }
            
        }
                
        return $nueva_frase;
    }

}
