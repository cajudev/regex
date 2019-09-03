<?php

namespace Cajudev;

class Regex {
    private $parser;
    private $matches = [];

    public function __construct(string $pattern) {
        $this->parse($pattern);
    }

    /**
     * Perform a regular expression match
     *
     * @param  string $subject
     *
     * @return bool
     */
    public function match(string $subject): bool {
        if ($this->parser->isGlobal()) {
            return preg_match_all($this->parser->getExpression(), $subject, $this->matches);
        }
        return preg_match($this->parser->getExpression(), $subject, $this->matches);
    }

    /**
     * Split a string by regular expresion
     *
     * @param  string $subject
     * @param  int    $limit
     * @param  int    $flags
     *
     * @return array
     */
    public function split(string $subject, int $limit = -1, int $flags = 0): array {
        return preg_split($this->parser->getExpression(), $subject, $limit, $flags);
    }

    /**
     * Perform a regular expression search and replace
     *
     * @param  string $subject
     * @param  string $replace
     * @param  int    $limit
     * @param  int    $count
     *
     * @return string
     */
    public function replace(string $subject, string $replace, int $limit = -1, int &$count = 0): string {
        return preg_replace($this->parser->getExpression(), $replace, $subject, $limit, $count);
    }
    
    /**
     * Get the result of a previous match
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function get(string $key = '0') {
        return $this->matches[$key] ?? false;
    }

    /**
     * Parse the current regular expression
     *
     * @param  string $pattern
     *
     * @return void
     */
    private function parse(string $pattern) {
        $this->parser = new RegexParser($pattern);
        $this->parser->parse();
    }
}