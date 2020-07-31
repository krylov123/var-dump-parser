<?php


namespace Krylov123;


class VarDumpParser
{
    protected $options = [];


    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param  array  $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    public function parseOutput($text)
    {
        $text = trim($text, PHP_EOL);
        $firstStrokeEnd = strpos($text, PHP_EOL) + strlen(PHP_EOL);
        $withoutFirstStroke = substr($text, $firstStrokeEnd);

        return $this->parseElement($withoutFirstStroke);
    }

    protected function parseElement($elementAsString)
    {
        //Exceptional behavior for null type
        if ($this->isNull($elementAsString)) {
            return null;
        }

        preg_match('/^(\w+)\(([\w\.\,]+)\)/', $elementAsString, $match);

        if(!isset($match[1])){
            var_dump([$elementAsString,$match]);
        }
        $type = $match[1];
        $length = $match[2];

        switch ($type) {
            case "bool":
                return ($length === 'true');
            case "int":
                return intval($length);
            case "double":
                return doubleval($length);
            case "float":
                return floatval($length);
            case "string":
                $content = substr($elementAsString, strlen($type."(".$length.") ") + 1, $length);
                return $content;
            case "array":
                $varExport = $this->arrayVarDumpToVarExport($elementAsString);
                eval('$result='.$varExport.';');
                return $result;
            default:
                break;
        }
    }

    protected function isNull($string)
    {
        $substr = substr($string, 0, 4);
        return $substr === 'NULL';
    }

    protected function arrayVarDumpToVarExport($string)
    {
        $string = preg_replace("/array\(\d+\) {/", "array (", $string);
        $string = preg_replace("/}.*$/", ")", $string);
        $string = preg_replace("/\[(\d+)\] =>".PHP_EOL."/", "$1 =>", $string);
        $string = preg_replace("/\\'(.+)\\' =>".PHP_EOL."/", "\"$1\" =>", $string);

        $array = explode(PHP_EOL, $string);
        $middleArray = array_slice($array, 1, count($array) - 2);
        $newArrayBodyString = '';
        foreach ($middleArray as $item) {
            $elements = explode(" =>  ", $item);
            $newArrayBodyString .= $elements[0].' => '.var_export($this->parseElement($elements[1]), true).',';
        }
        return 'array('.$newArrayBodyString.')';
    }

}
