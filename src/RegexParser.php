<?php

namespace Cajudev;

class RegexParser {
    private $pattern;
    private $global;

    public function __construct(string $pattern) {
        $this->pattern = $pattern;
        $this->global  = false;
    }

    public function parse() {
        set_error_handler([$this, 'handler'], E_WARNING);
        preg_match($this->pattern, 'error test');
        restore_error_handler();
    }

    private function handler(int $errno , string $errstr) {
        $errorMessage = substr($errstr, 14);
        if ($errorMessage !== "Unknown modifier 'g'") {
            throw new RegularExpressionException($errorMessage);
        }
        $this->global  = true;
        $this->pattern = preg_replace('/(.+)(g)/', '\\1', $this->pattern);
    }

    public function getExpression(): string {
        return $this->pattern;
    }

    public function isGlobal(): bool {
        return $this->global;
    }
}