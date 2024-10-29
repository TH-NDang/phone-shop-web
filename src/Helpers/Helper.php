<?php
class Helper
{
    public static function formatPrice($price)
    {
        return number_format($price, 0, ',', '.') . '₫';
    }

    public static function formatImageUrl($imageUrl)
    {
        // Ensure image URL starts with forward slash
        return strpos($imageUrl, '/') === 0 ? $imageUrl : '/' . $imageUrl;
    }

    public static function truncateText($text, $length = 100)
    {
        if (strlen($text) > $length) {
            return substr($text, 0, $length) . '...';
        }
        return $text;
    }
}
