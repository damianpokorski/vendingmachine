<?php

namespace VendingMachine\Display;

use VendingMachine\Display\DisplayInterface;

class MemoryDisplay implements DisplayInterface
{
    /**
     *
     * @var string
     */
    private $content = '';

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
