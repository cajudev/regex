<?php

namespace Cajudev;

use PHPUnit\Framework\TestCase;

class RegexTest extends TestCase {
    public function test_should_return_true_when_match() {
        $regex = new Regex('/\w/');
        $this->assertTrue($regex->match('lorem'));
    }

    public function test_should_return_false_when_match() {
        $regex = new Regex('/\d/');
        $this->assertFalse($regex->match('lorem'));
    }

    public function test_should_get_data_after_match() {
        $regex = new Regex('/\w/');
        $regex->match('lorem');
        $this->assertEquals('l', $regex->get());
    }

    public function test_should_get_data_of_named_groups_after_match() {
        $regex = new Regex('/(\w+)(?<last>\w)/');
        $regex->match('lorem');
        $this->assertEquals('m', $regex->get('last'));
    }

    public function test_should_perform_global_regular_expression_when_using_g_flag() {
        $regex = new Regex('/\w/g');
        $regex->match('lorem');
        $this->assertEquals(['l', 'o', 'r', 'e', 'm'], $regex->get());
    }

    public function test_should_throws_exception_when_any_warning_is_thrown() {
        $this->expectException(RegularExpressionException::class);
        $regex = new Regex('/\w');
    }

    public function test_should_perform_replace() {
        $regex = new Regex('/\d/');
        $this->assertEquals('lrm', $regex->replace('l0r3m', ''));
    }

    public function test_should_perform_split() {
        $regex = new Regex('/\d/');
        $this->assertEquals(['l', 'r', 'm'], $regex->split('l0r3m'));
    }
}