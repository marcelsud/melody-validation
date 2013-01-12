<?php

namespace Melody\Validation\Constraints;

use Melody\Validation\ConstraintsBuilder as c;

class MaxLengthTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerForValidStrings
     */
    public function test_valid_string_should_pass($validString)
    {
        $this->assertTrue(c::maxLength(10)->validate($validString));
    }

    /**
     * @dataProvider providerForInvalidStrings
     */
    public function test_invalid_string_should_fail_validation($invalidString)
    {
        $this->assertFalse(c::maxLength(3)->validate($invalidString));
    }

    public function providerForValidStrings()
    {
        return array(
                array('abc'),
                array('abcdef'),
                array('abcdef1234')
        );
    }

    public function providerForInvalidStrings()
    {
        return array(
                array('abcd'),
                array('abcdef'),
                array('abcdef1234')
        );
    }

}