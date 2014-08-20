<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Cli;

use Star\TicTacToe\Game;
use Star\TicTacToe\Grid\ColumnRowGrid;
use Star\TicTacToe\Player;
use Symfony\Component\Console\Application as BaseApp;

/**
 * Class Application
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Cli
 */
class Application extends BaseApp
{
    const VERSION = '1.0.0';

    public function __construct()
    {
        parent::__construct('Tic Tac Toe', self::VERSION);

        $this->add(new PlayCommand());
    }
}
 