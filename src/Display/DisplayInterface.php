<?php

namespace VendingMachine\Display;

interface DisplayInterface
{
    /**
     * Sets the value to be displayed
     *
     * @param string $content
     * @return void
     */
    public function setContent(string $content);

    /**
     * Gets the currently displayed value
     *
     * @return string
     */
    public function getContent(): string;
}
