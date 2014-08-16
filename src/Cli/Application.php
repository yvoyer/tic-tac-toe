<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Cli;

use Star\TicTacToe\Game;
use Star\TicTacToe\Player;
use Star\TicTacToe\Repository\InMemoryRepository;
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

    /**
     * @var InMemoryRepository
     */
    private $repository;

    public function __construct()
    {
        parent::__construct('Tic Tac Toe', self::VERSION);

        $player1 = new Player('X', 'Player 1');
        $player2 = new Player('O', 'Player 2');
        $this->repository = new InMemoryRepository(new Game($player1, $player2));
        $this->repository->addPlayer($player1);
        $this->repository->addPlayer($player2);

        $this->add(new PlayCommand($this->repository));
    }
}
 