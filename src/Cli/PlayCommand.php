<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Cli;

use Star\TicTacToe\Display\ConsoleDisplay;
use Star\TicTacToe\Grid\ColumnRowGrid;
use Star\TicTacToe\Id\ColumnRowId;
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
    }

    /**
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int     null or 0 if everything went fine, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /**
         * @var DialogHelper $dialog
         */
        $dialog = $this->getHelper('dialog');

        $player1Name = $dialog->ask($output, 'Entrez le nom du joueur 1: ');
        $player1 = new Player('X', $player1Name);

        $player2Name = $dialog->ask($output, 'Entrez le nom du joueur 2: ');
        $player2 = new Player('O', $player2Name);

        $game = new Game($player1, $player2, new ColumnRowGrid());

        $i = 0;
        $game->start($player1);
        while (false === $game->isFinished()) {
            $currentPlayer = $game->getCurrentPlayer();
            $output->writeln("{$currentPlayer->getName()}, c'est votre tour.");
            $display = new ConsoleDisplay($output);

            $game->render($display);

            $position = $dialog->askAndValidate($output, 'Position: ', function($string) {
                    if (! preg_match('/([abc)(,)([123])/', $string)) {
                        throw new \InvalidArgumentException('The position must be in format X,Y');
                    }

                    return $string;
                }
            );
            $aPos = explode(',', $position);
            $col = $aPos[0];
            $row = $aPos[1];

            try {
                $game->playTurn(new ColumnRowId($col, $row));
            } catch (\Exception $e) {
                $output->writeln('<error>' . $e->getMessage() . '</error>');
            }

            $i ++;
        }

        $result = $game->finish();
        if ($result->isWin()) {
            $output->writeln('Game is won by: ' . $result->getWinner()->getName());
        }

        if ($result->isDraw()) {
            $output->writeln('Game is a tie');
        }
    }
}
 