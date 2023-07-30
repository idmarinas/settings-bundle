<?php

declare(strict_types = 1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SensiolabsSetList;
use Rector\Symfony\Set\SymfonyLevelSetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\Symfony\Set\TwigSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ]);

    $rectorConfig->phpVersion(PhpVersion::PHP_81);
    $rectorConfig->importNames(true, false);
    $rectorConfig->importShortClasses(true);
    $rectorConfig->symfonyContainerXml(__DIR__.'/var/cache/dev/App_KernelDevDebugContainer.xml');

    $rectorConfig->import(SetList::DEAD_CODE);
    $rectorConfig->import(SetList::CODE_QUALITY);
    $rectorConfig->import(LevelSetList::UP_TO_PHP_81);
    $rectorConfig->import(SetList::PHP_82);

    // -- Symfony Framework
    $rectorConfig->import(SymfonyLevelSetList::UP_TO_SYMFONY_44);
    $rectorConfig->import(SymfonySetList::SYMFONY_CODE_QUALITY);
    $rectorConfig->import(SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION);
    $rectorConfig->import(SensiolabsSetList::FRAMEWORK_EXTRA_61);
    $rectorConfig->import(TwigSetList::TWIG_240);
    $rectorConfig->import(TwigSetList::TWIG_UNDERSCORE_TO_NAMESPACE);
    $rectorConfig->import(DoctrineSetList::DOCTRINE_25);
    $rectorConfig->import(DoctrineSetList::DOCTRINE_ORM_29);
    $rectorConfig->import(DoctrineSetList::DOCTRINE_ORM_213);
    $rectorConfig->import(DoctrineSetList::DOCTRINE_CODE_QUALITY);
    $rectorConfig->import(DoctrineSetList::DOCTRINE_COMMON_20);
    $rectorConfig->import(DoctrineSetList::DOCTRINE_DBAL_210);
    $rectorConfig->import(DoctrineSetList::DOCTRINE_DBAL_211);
    $rectorConfig->import(DoctrineSetList::DOCTRINE_DBAL_30);

    // -- Skip some rules/files ...
    // $rectorConfig->skip([
    //     ShortenElseIfRector::class,
    // ]);
};
