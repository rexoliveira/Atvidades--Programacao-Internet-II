<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3800e983a9a8152de728d529ca87e66b
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3800e983a9a8152de728d529ca87e66b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3800e983a9a8152de728d529ca87e66b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3800e983a9a8152de728d529ca87e66b::$classMap;

        }, null, ClassLoader::class);
    }
}
