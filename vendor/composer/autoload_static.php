<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit235fde941ffc4bbcc90de329e1eedee4
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PhpOffice\\PhpWord\\' => 18,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'L' => 
        array (
            'Laminas\\Escaper\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PhpOffice\\PhpWord\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phpword/src/PhpWord',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Laminas\\Escaper\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-escaper/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit235fde941ffc4bbcc90de329e1eedee4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit235fde941ffc4bbcc90de329e1eedee4::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
