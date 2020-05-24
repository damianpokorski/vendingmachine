<?php

namespace VendingMachine\Display;

use VendingMachine\Display\Contracts\DisplayInterface;

class MemoryDisplay implements DisplayInterface
{
    /**
     *
     * @var string
     */
    private $content = '';

    /**
     *
     * @var string
     */
    private $temporaryContent = '';

    public function setContent(string $content, $temporary = false)
    {
        if ($temporary) {
            $this->temporaryContent = $content;
            return;
        }
        $this->content = $content;
    }

    public function getContent(): string
    {
        if (\strlen($this->temporaryContent) > 0) {
            $displayValue = $this->temporaryContent;
            $this->temporaryContent = '';
            return $displayValue;
        }
        return $this->content;
    }
}
