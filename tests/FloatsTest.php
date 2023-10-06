<?php

namespace TraderInteractive\Filter;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \TraderInteractive\Filter\Floats
 * @covers ::<private>
 */
final class FloatsTest extends TestCase
{
    /**
     * @test
     * @covers ::filter
     */
    public function filterAllowNullIsTrueAndNullValue()
    {
        $this->assertNull(Floats::filter(null, true));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterPositiveFloat()
    {
        $this->assertSame(123.0, Floats::filter(123.0));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterNegativeFloat()
    {
        $this->assertSame(-123.0, Floats::filter(-123.0));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterZeroFloat()
    {
        $positiveZero = + 0.0;
        $this->assertSame(0.0, Floats::filter($positiveZero));
        $this->assertSame(-0.0, Floats::filter(-0.0));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterPositiveString()
    {
        $this->assertSame(123.0, Floats::filter('   123 '));
        $this->assertSame(123.0, Floats::filter('   +123 '));
        $this->assertSame(123.0, Floats::filter('   123.0 '));
        $this->assertSame(123.0, Floats::filter('   123E0 '));
        $this->assertSame(123.0, Floats::filter('   +123e0 '));
        $this->assertSame(123.0, Floats::filter('   +1230e-1 '));
        $this->assertSame(1230.0, Floats::filter('   +123e+1 '));
        $this->assertSame(0.0, Floats::filter('   +0 '));
        $this->assertSame(0.0, Floats::filter('   +0.0 '));
        $this->assertSame(0.0, Floats::filter('   0E0 '));
        $this->assertSame(0.0, Floats::filter('   00e-1 '));
        $this->assertSame(0.0, Floats::filter('   00e+1 '));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterNegativeString()
    {
        $this->assertSame(-123.0, Floats::filter('   -123 '));
        $this->assertSame(-123.0, Floats::filter('   -123.0 '));
        $this->assertSame(-123.0, Floats::filter('   -123E0 '));
        $this->assertSame(-123.0, Floats::filter('   -1230E-1 '));
        $this->assertSame(-1230.0, Floats::filter('   -123e+1 '));
        $this->assertSame(-0.0, Floats::filter('   -0 '));
        $this->assertSame(-0.0, Floats::filter('   -0.0 '));
        $this->assertSame(-0.0, Floats::filter('   -0e0 '));
        $this->assertSame(-0.0, Floats::filter('   -00e-1 '));
        $this->assertSame(-0.0, Floats::filter('   -0e+1 '));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterNonStringOrFloat()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('"true" $value is not a string');
        Floats::filter(true);
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterEmptyString()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage(' does not pass is_numeric');
        Floats::filter('');
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterWhitespaceString()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage(' does not pass is_numeric');
        Floats::filter('   ');
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterNonDigitString()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('123-4 does not pass is_numeric');
        Floats::filter('123-4');
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterHexString()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        Floats::filter('0xFF');
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterRogueSpaceStringAfterPeriod()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('1. 0 does not pass is_numeric');
        Floats::filter('1. 0');
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterRogueSpaceStringBetweenDigits()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('1 0 does not pass is_numeric');
        Floats::filter('1 0');
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterOverflow()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('1e999999999999 overflow');
        Floats::filter('1e999999999999');
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterUnderflow()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('-1e999999999999 overflow');
        Floats::filter('-1e999999999999');
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterLessThanMin()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('-1 is less than 0');
        Floats::filter(-1.0, false, 0.0);
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterEqualToMin()
    {
        $this->assertSame(0.0, Floats::filter(0.0, false, 0.0));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterGreaterThanMax()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('1 is greater than 0');
        Floats::filter(1.0, false, null, 0.0);
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterEqualToMax()
    {
        $this->assertSame(0.0, Floats::filter(0.0, false, null, 0.0));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterCastInts()
    {
        $this->assertSame(1.0, Floats::filter(1, false, null, null, true));
    }

    /**
     * @test
     * @covers ::filter
     */
    public function filterCastIntsIsFalse()
    {
        $this->expectException(\TraderInteractive\Exceptions\FilterException::class);
        $this->expectExceptionMessage('"1" $value is not a string');
        Floats::filter(1, false, null, null, false);
    }
}
