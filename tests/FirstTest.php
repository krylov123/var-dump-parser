<?php

use PHPUnit\Framework\TestCase;

final class FirstTest extends TestCase
{
    protected $parser;

    public function var_dump_to_string($anything)
    {
        ob_start();
        var_dump($anything);
        $string = ob_get_clean();
        //replace any terminal codes that may be added by OS cli (ex. \033[22m:)
        $result = preg_replace('#\\x1b[[][^A-Za-z]*[A-Za-z]#', '', $string);
        return $result;
    }

    protected function setUp()
    {
        parent::setUp();
        $this->parser = new \Krylov123\VarDumpParser();
    }

    public function test_parse_simple_string()
    {
        $testVariable = "Simple string will be var_dumped";
        $string = $this->var_dump_to_string($testVariable);
        $result = $this->parser->parseOutput($string);
        $this->assertSame($testVariable, $result);
    }

    public function test_parse_null()
    {
        $testVariable = null;
        $string = $this->var_dump_to_string($testVariable);
        $result = $this->parser->parseOutput($string);
        $this->assertSame($testVariable, $result);
    }

    public function test_parse_bool()
    {
        $testVariable = true;
        $string = $this->var_dump_to_string($testVariable);
        $result = $this->parser->parseOutput($string);
        $this->assertSame($testVariable, $result);
    }

    public function test_parse_int()
    {
        $testVariable = 5;
        $string = $this->var_dump_to_string($testVariable);
        $result = $this->parser->parseOutput($string);
        $this->assertSame($testVariable, $result);
    }

    public function test_parse_double()
    {
        $testVariable = 0.2;
        $string = $this->var_dump_to_string($testVariable);
        $result = $this->parser->parseOutput($string);
        $this->assertSame($testVariable, $result);
    }

    public function test_parse_plain_array()
    {
        $testVariable = [1, 2, 3, 4];
        $string = $this->var_dump_to_string($testVariable);
        $result = $this->parser->parseOutput($string);
        $this->assertSame($testVariable, $result);
    }

    public function test_parse_associative_array()
    {
        $testVariable = ['one' => 'apple', 'two' => 2, 'three' => 2.2];
        $string = $this->var_dump_to_string($testVariable);
        $result = $this->parser->parseOutput($string);
        $this->assertSame($testVariable, $result);
    }

    public function test_parse_multidimension_array()
    {
        $testVariable = ['one' => 'apple', 'two' => ["subone" => 1], 'three' => 2.2];
        $string = $this->var_dump_to_string($testVariable);
        $result = $this->parser->parseOutput($string);
        $this->assertSame($testVariable, $result);
    }
}