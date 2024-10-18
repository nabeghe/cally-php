<?php declare(strict_types=1);

use Nabeghe\Cally\Cally;

class CallyTest extends \PHPUnit\Framework\TestCase
{
    public function testAction()
    {
        $entry = 13;
        $expected = 169;
        $actual = 0;

        $actions = [
            function ($plus) use (&$actual) {
                $actual += $plus;
            },
            function ($plus) use (&$actual) {
                $actual *= $plus;
            },
        ];

        Cally::action($actions, $entry);

        $this->assertSame($expected, $actual);
    }

    public function testCall()
    {
        $this->assertSame(182, Cally::call([Math::class, 'multiple', 13], 14));
    }

    public function testFilter()
    {
        $entry = 13;
        $expected = 378;

        $filters = [
            function ($number, $plus) {
                $number += $plus;
                return $number;
            },
            function ($number, $plus) {
                $number *= $plus;
                return $number;
            },
        ];

        $actual = Cally::filter($filters, $entry, 14);

        $this->assertSame($expected, $actual);
    }

    public function testOb()
    {
        $this->assertSame('nabeghe/cally', Cally::ob(function () {
            echo 'nabeghe/cally';
        }));
    }

    public function testTap()
    {
        $entry = 13;
        $expected = $entry + 1;

        $actual = Cally::tap($entry, function (&$value) {
            $value++;
        });

        $this->assertSame($expected, $actual);
    }

    public function testTry()
    {
        $entry = 13;
        $actual = 0;
        $expected = $entry * 14;
        Cally::try(function () use (&$actual) {
            $actual = 14;
        }, function () use ($entry, &$actual) {
            $actual = $entry * $actual;
        });
        $this->assertSame($expected, $actual);

        Cally::try(function () use (&$actual) {
            throw new Exception();
        }, null, $error);
        $this->assertInstanceOf(Exception::class, $error);
    }

    public function testValue()
    {
        $entry = 13;
        $expected = $entry;
        $actual = Cally::value($entry);
        $this->assertSame($expected, $actual);

        $entry1 = 13;
        $entry2 = 14;
        $expected = $entry1 * $entry2;
        $actual = Cally::value(function ($arg1, $arg2) {
            return $arg1 * $arg2;
        }, $entry1, $entry2);
        $this->assertSame($expected, $actual);
    }

    public function testValback()
    {
        $this->assertSame(13, Cally::valback(13)());
        $this->assertSame(14, Cally::valback(14)());
    }

    public function testWith()
    {
        $entry = 13;
        $expected = $entry * 14;

        $actual = Cally::with($entry, function ($value) {
            return $value * 14;
        });

        $this->assertSame($expected, $actual);
    }
}

class Math
{
    public static function multiple($number1, $number2)
    {
        return $number1 * $number2;
    }
}