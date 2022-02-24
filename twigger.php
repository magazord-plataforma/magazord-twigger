#!/usr/local/bin/php
<?php

$autoLoader = require __DIR__ . '/vendor/autoload.php';

$loader = new \Twig\Loader\ArrayLoader([]);
$twigInstance = new \Twig\Environment($loader);
$twigInstance->addExtension(new \MagaZord\TwigLint\MockExtension());

$app = new \Symfony\Component\Console\Application();
$app->add(new \Symfony\Bridge\Twig\Command\LintCommand($twigInstance));
$app->run();