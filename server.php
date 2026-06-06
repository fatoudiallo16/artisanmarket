<?php

/**
 * Vercel serverless entry: serve static files from /public, then Laravel.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

if ($uri !== '/' && file_exists($file = __DIR__.'/public'.$uri)) {
    header('Content-Type: '.get_mime_type($file).'; charset=UTF-8');
    readfile($file);

    return;
}

require_once __DIR__.'/public/index.php';

function get_mime_type(string $filename): string
{
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    $mimes = [
        'txt' => 'text/plain',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'webp' => 'image/webp',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'mp3' => 'audio/mpeg',
        'woff' => 'application/font-woff',
        'woff2' => 'font/woff2',
        'ttf' => 'application/x-font-ttf',
        'otf' => 'font/otf',
    ];

    return $mimes[$extension] ?? 'application/octet-stream';
}
