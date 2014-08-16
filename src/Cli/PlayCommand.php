<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Cli;

use Star\TicTacToe\ColumnRowId;
use Star\TicTacToe\Game;
use Star\TicTacToe\Player;
use Star\TicTacToe\Repository\InMemoryRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PlayCommand
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Cli
 */
class PlayCommand extends Command
{
    /**
     * @var InMemoryRepository
     */
    private $repository;

    /**
     * @param InMemoryRepository $repository
     */
    public function __construct(InMemoryRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct('play');
    }

    protected function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the player');
        $this->addArgument('column', InputArgument::REQUIRED, 'The column to place the token');
        $this->addArgument('row', InputArgument::REQUIRED, 'The row to place the token');
    }

    /**
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int     null or 0 if everything went fine, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $game = $this->repository->getGame();

        $i = 0;
        while ($i < 9) {
            /**
             * @var DialogHelper $dialog
             */
            $dialog = $this->getHelper('dialog');
            $output->writeln('Player X turn.');

            $dialog->ask($output, 'Position: ');
            $player = $this->repository->findPlayer($input->getArgument('name'));

            $col = $input->getArgument('column');
            $row = $input->getArgument('row');

            $game->playTurn($player, new ColumnRowId($col, $row));

            $i ++;
        }
    }
}
 