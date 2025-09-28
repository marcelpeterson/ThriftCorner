<?php

if (! function_exists('rupiah')) {
    /**
     * Format a number into Indonesian Rupiah currency string.
     */
    function rupiah(null|int|float|string $amount, bool $withPrefix = true): string
    {
        if ($amount === null || $amount === '') {
            $amount = 0;
        }
        $normalized = (float) $amount;
        $formatted = number_format($normalized, 0, ',', ',');
        return $withPrefix ? 'Rp ' . $formatted : $formatted;
    }
}
