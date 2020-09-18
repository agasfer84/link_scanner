<?php
namespace tests;
use PHPUnit\Framework\TestCase;
use models\Files;

class FilesTest extends TestCase
{

    public function testGetTable()
    {
        $instance = new Files();
        $result = $instance->getTable();
        $this->assertEquals("link_files", $result);
    }

//    public function testExample()
//    {
//        $this->assertTrue(true);
//    }

}