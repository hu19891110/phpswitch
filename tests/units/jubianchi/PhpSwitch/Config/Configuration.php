<?php
namespace tests\units\jubianchi\PhpSwitch\Config;

use mageekguy\atoum;
use jubianchi\PhpSwitch\Config\Configuration as TestedClass;

require_once __DIR__ . '/../../../bootstrap.php';

class Configuration extends atoum\test
{
    public function testClass()
    {
        $this
            ->testedClass
                ->isSubclassOf('\\IteratorAggregate')
        ;
    }

    public function testGet()
    {
        $this
            ->if($object = new TestedClass())
            ->and($offset = uniqid())
            ->then
                ->exception(function() use($object, $offset) {
                    $object->get($offset);
                })
                    ->isInstanceOf('\\InvalidArgumentException')
                    ->hasMessage(sprintf('Offset %s does not exist', $offset))
            ->if($value = null)
            ->and($object->set($offset, $value))
            ->then
                ->exception(function() use($object, $offset) {
                    $object->get($offset);
                })
                    ->isInstanceOf('\\InvalidArgumentException')
                    ->hasMessage(sprintf('Offset %s does not exist', $offset))
            ->if($value = uniqid())
            ->and($object->set($offset, $value))
            ->then
                ->variable($object->get($offset))->isIdenticalTo($value)
        ;
    }

    public function testSet()
    {
        $this
            ->if($object = new TestedClass())
            ->and($offset = uniqid())
            ->and($value = uniqid())
            ->then
                ->object($object->set($offset, $value))->isIdenticalTo($object)
                ->variable($object->get($offset))->isIdenticalTo($value)
        ;
    }

    public function testSetValues()
    {
        $this
            ->if($object = new TestedClass())
            ->and($values = array(uniqid() => uniqid()))
            ->then
                ->object($object->setValues($values))->isIdenticalTo($object)
                ->array($object->getValues())->isIdenticalTo($values)
        ;
    }

    public function testGetValues()
    {
        $this
            ->if($object = new TestedClass())
            ->then
                ->array($object->getValues())->isEmpty()
            ->if($values = array(uniqid() => uniqid()))
            ->and($object->setValues($values))
            ->then
                ->array($object->getValues())->isIdenticalTo($values)
        ;
    }

    public function testGetIterator()
    {
        $this
            ->if($object = new TestedClass())
            ->then
                ->object($object->getIterator())->isInstanceOf('\\RecursiveArrayIterator')
                ->array((array) $object->getIterator())->isEmpty()
            ->if($values = array(uniqid() => uniqid()))
            ->and($object->setValues($values))
            ->then
                ->array((array) $object->getIterator())->isEqualTo($values)
        ;
    }

    public function testDump()
    {
        $this
            ->mockGenerator->shuntParentClassCalls()
            ->if($dumper = new \mock\jubianchi\PhpSwitch\Config\Dumper())
            ->if($object = new TestedClass(uniqid(), $dumper))
            ->and($object->setPath($path = uniqid()))
            ->and($object->setDumper($dumper))
            ->then
                ->object($object->dump())->isIdenticalTo($object)
                ->mock($dumper)
                    ->call('dump')->withArguments($path, $object)->once()
        ;
    }

    public function testSetDumper()
    {
        $this
            ->if($object = new TestedClass())
            ->and($dumper = new \mock\jubianchi\PhpSwitch\Config\Dumper())
            ->then
                ->object($object->setDumper($dumper))->isIdenticalTo($object)
                ->object($object->getDumper())->isIdenticalTo($dumper)
        ;
    }

    public function testGetDumper()
    {
        $this
            ->if($object = new TestedClass())
            ->then
                ->object($object->getDumper())->isInstanceOf('\\jubianchi\\PhpSwitch\\Config\\Dumper')
            ->if($dumper = new \mock\jubianchi\PhpSwitch\Config\Dumper())
            ->and($object->setDumper($dumper))
            ->then
                ->object($object->getDumper())->isIdenticalTo($dumper)
        ;
    }
}
