<?php

class ImportFileTest  extends PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        Yii::import('application.models.TestModel', true);
    }

    public function testImport()
    {
        $this->assertTrue(class_exists('TestModel', false));
        $this->assertFalse(class_exists('TestTagModel', false));
    }
}