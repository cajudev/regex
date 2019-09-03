<?php

namespace Cajudev;

class RegexParser {
    private $pattern;
    private $global;
    private $errorMessage;

    public function __construct(string $pattern) {
        $this->pattern = $pattern;
        $this->global  = false;
    }

    public function parse() {
        $this->setHandler();
        $this->makeSimpleTest();
        $this->restoreHandler();
        $this->throwExceptionIfError();
    }

    /**
     * Setup the temporary custom warning error handler
     *
     * @return void
     */
    private function setHandler() {
        set_error_handler([$this, 'handleError'], E_WARNING);
    }

    /**
     * Do a simple preg_match built-in function just to test if any error will be thrown
     *
     * @return void
     */
    private function makeSimpleTest() {
        preg_match($this->pattern, 'string test');
    }

    /**
     * Parse the error message, setting up as global when modifier 'g' was used
     * otherwise, set the corresponding error message
     *
     * @param  int    $errno
     * @param  string $errstr
     *
     * @return void
     */
    public function handleError(int $errno , string $errstr) {
        $errorMessage = substr($errstr, 14);
        if ($errorMessage !== "Unknown modifier 'g'") {  
            $this->setErrorMessage($errorMessage);
        } else {
            $this->setAsGlobal();
        }
    }

    /**
     * Restore the original error handler
     *
     * @return void
     */
    private function restoreHandler() {
        restore_error_handler();
    }

    /**
     * If any error message was set, throws a exception
     *
     * @return void
     */
    private function throwExceptionIfError() {
        if ($this->errorMessage) {
            throw new RegularExpressionException($this->errorMessage);
        }
    }

    /**
     * Set the error message
     *
     * @param  string $errorMessage
     *
     * @return void
     */
    private function setErrorMessage(string $errorMessage) {
        $this->errorMessage = $errorMessage;
    }

    /**
     * Set the current regular expression as global
     *
     * @return void
     */
    private function setAsGlobal() {
        $this->global  = true;
        $this->pattern = preg_replace('/(.+)(g)/', '\\1', $this->pattern);
    }

    /**
     * Return the current regular expression
     *
     * @return string
     */
    public function getExpression(): string {
        return $this->pattern;
    }

    /**
     * Inform whether the current regular expression is global or not
     *
     * @return bool
     */
    public function isGlobal(): bool {
        return $this->global;
    }
}