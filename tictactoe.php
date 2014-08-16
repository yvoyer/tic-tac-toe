#!/usr/bin/env php
<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

require_once 'vendor/autoload.php';

$argv[] = '--ansi';
$app = new \Star\TicTacToe\Cli\Application();
$app->run(new \Symfony\Component\Console\Input\ArgvInput($argv));