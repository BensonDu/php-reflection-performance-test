<?php
/**
 *  PHP 反射性能测试
 *
 */
define('NUM_TESTS', 1000000);
header('Content-type: text/plain');
$_ENV['total'] = microtime(true);
$_ENV['start'] = 0;
$_ENV['end'] = 0;

class Foo
{
    public $a;
    protected $b;
    private $c;

    public function time() {
        return $_ENV['end'] = microtime(true);
    }
    protected function bar($a,$b,$c) {}
    private function baz($a,$b,$c) {}
}
//开始计时
$_ENV['start'] = microtime(true);
$instance = 0;
for ($i=0; $i<NUM_TESTS; $i++) {
    $ref = new ReflectionClass('Foo');
    $instance  = $ref->newInstanceArgs();
    $instance->time();
}
echo "反射类 实例化# " .NUM_TESTS .'次,耗时'. number_format(($_ENV['end'] - $_ENV['start'])*1000, 3) . " ms\n";

//开始计时
$_ENV['start'] = microtime(true);
$ref = 0;
for ($i=0; $i<NUM_TESTS; $i++) {
    $ref = new Foo();
    $ref->time();
}
echo "正常实例化# " .NUM_TESTS .'次,耗时'. number_format(($_ENV['end'] - $_ENV['start'])*1000, 3) . " ms\n";


echo '总耗时 # '.number_format(((microtime(true) - $_ENV['total']))*1000,3)." ms\n";