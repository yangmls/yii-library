<?php

class AutoloadTest extends PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        Yii::import('application.components.*');
    }
    
    public function testNamespace()
    {
        $component = new \Test\Component;
        
        $this->assertTrue(class_exists('\\Test\\Component', false));
        
        $this->assertEquals($component->id, 1);
        
        $component2 = new \Test\Test\Component;
        
        $this->assertTrue(class_exists('\\Test\\Test\\Component', false));
        
        $this->assertEquals($component2->id, 2);
    }
}