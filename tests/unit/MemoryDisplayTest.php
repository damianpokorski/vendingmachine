<?php

namespace VendingMachine\Tests\Feature;

use PHPUnit\Framework\TestCase;
use VendingMachine\Display\MemoryDisplay;

class MemoryDisplayTest extends TestCase
{
    public function testCanConstructMemoryDisplay()
    {
        $this->assertNotNull(new MemoryDisplay);
    }

    public function testCanAssignAndReadContentsOfDisplay()
    {
        $display = new MemoryDisplay;
        $message = "Sample message";
        $display->setContent($message);
        
        $this->assertEquals($message, $display->getContent());
    }
}
