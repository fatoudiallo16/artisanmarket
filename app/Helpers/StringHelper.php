<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * Générer un slug à partir d'une chaîne
     */
    public static function slug(string $text): string
    {
        return strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', iconv('UTF-8', 'ASCII//TRANSLIT', $text)), '-'));
    }

    /**
     * Tronquer une chaîne avec des points de suspension
     */
    public static function truncate(string $text, int $length = 100): string
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . '...';
    }

    /**
     * Formater une date en français
     */
    public static function formatDate(\DateTime $date): string
    {
        return $date->format('d/m/Y H:i');
    }
}
