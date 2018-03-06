<?php

namespace TraderInteractive\Filter;

use TraderInteractive\Exceptions\FilterException;

/**
 * A collection of filters for floats.
 */
final class Floats
{
    /**
     * Filters $value to a float strictly.
     *
     * The return value is the float, as expected by the \TraderInteractive\Filterer class.
     *
     * @param mixed $value     The value to filter to a float.
     * @param bool  $allowNull Set to true if NULL values are allowed. The filtered result of a NULL value is NULL.
     * @param float $minValue  The minimum acceptable value.
     * @param float $maxValue  The maximum acceptable value.
     * @param bool  $castInts  Flag to cast $value to float if it is an integer.
     *
     * @return float|null The filtered value
     *
     * @throws FilterException Thrown if the given value cannot be filtered to a float.
     */
    public static function filter(
        $value,
        bool $allowNull = false,
        float $minValue = null,
        float $maxValue = null,
        bool $castInts = false
    ) {
        if ($allowNull === true && $value === null) {
            return null;
        }

        if (is_float($value)) {
            return self::ensureValueNotInfiniteAndInRange($value, $value, $minValue ?? -INF, $maxValue ?? INF);
        }

        if (is_int($value) && $castInts) {
            return self::ensureValueNotInfiniteAndInRange($value, (float)$value, $minValue ?? -INF, $maxValue ?? INF);
        }

        if (is_string($value)) {
            $floatValue = self::fromString($value);
            return self::ensureValueNotInfiniteAndInRange($value, $floatValue, $minValue ?? -INF, $maxValue ?? INF);
        }

        throw new FilterException('"' . var_export($value, true) . '" $value is not a string');
    }

    private static function fromString(string $value) : float
    {
        $value = strtolower(trim($value));
        if (!is_numeric($value)) {
            throw new FilterException("{$value} does not pass is_numeric");
        }

        //This is the only case (that we know of) where is_numeric does not return correctly cast-able float
        if (strpos($value, 'x') !== false) {
            throw new FilterException("{$value} is hex format");
        }

        return (float)$value;
    }

    private static function ensureValueNotInfiniteAndInRange(
        $unfilteredValue,
        float $floatValue,
        float $minValue,
        float $maxValue
    ) : float {
        if (is_infinite($floatValue)) {
            throw new FilterException("{$unfilteredValue} overflow");
        }

        return self::ensureValueInRange($floatValue, $minValue, $maxValue);
    }

    private static function ensureValueInRange(float $value, float $minValue, float $maxValue) : float
    {
        if ($value < $minValue) {
            throw new FilterException("{$value} is less than {$minValue}");
        }

        if ($value > $maxValue) {
            throw new FilterException("{$value} is greater than {$maxValue}");
        }

        return $value;
    }
}
