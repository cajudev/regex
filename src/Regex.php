<?php

namespace Cajudev;

class Regex {
    private $parser;
    private $matches = [];

    public function __construct(string $pattern) {
        $this->parse($pattern);
    }

    public function match(string $subject): bool {
        if ($this->parser->isGlobal()) {
            return preg_match_all($this->parser->getExpression(), $subject, $this->matches);
        }
        return preg_match($this->parser->getExpression(), $subject, $this->matches);
    }

    public function split(string $subject, int $limit = -1, int $flags = 0): array {
        return preg_split($this->parser->getExpression(), $subject, $limit, $flags);
    }

    public function replace(string $subject, string $replace, int $limit = -1, int &$count = 0): string {
        return preg_replace($this->parser->getExpression(), $replace, $subject, $limit, $count);
    }
    
    public function get(string $key = '0') {
        return $this->matches[$key] ?? false;
    }

    private function parse(string $pattern) {
        $this->parser = new RegexParser($pattern);
        $this->parser->parse();
    }
}