<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Cli;

use Star\TicTacToe\Display\ConsoleDisplay;
use Star\TicTacToe\Grid\ColumnRowGrid;
use Star\TicTacToe\Game;
use Star\TicTacToe\Grid\NumberGrid;
use Star\TicTacToe\NullResult;
use Star\TicTacToe\Player;
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
    public function __construct()
    {
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
        $player1 = new Player('<comment>X</comment>', '<comment>' . $player1Name . '</comment>');

        $player2Name = $dialog->ask($output, 'Entrez le nom du joueur 2: ');
        $player2 = new Player('<info>O</info>', '<info>' . $player2Name . '</info>');

//        $grid = new ColumnRowGrid();
        while (true) {
            $grid = new NumberGrid();
            $game = new Game($player1, $player2, $grid);
            $game->start($player1);

            $result = new NullResult();
            while (false === $game->isFinished()) {
                $currentPlayer = $game->getCurrentPlayer();
                $output->writeln("{$currentPlayer->getName()}<question>, c'est votre tour.</question>");
                $game->render(new ConsoleDisplay($output));

                $id = $dialog->askAndValidate($output, 'Position: ', function($string) use ($grid) {
                        return $grid->createId($string);
                    }
                );

                try {
                    $result = $game->playTurn($id);
                } catch (\Exception $e) {
                    $output->writeln("<error>{$e->getMessage()}</error>");
                }
            }

            if ($result->isWin()) {
                $output->writeln("<info>Game is won by:</info> {$result->getWinner()->getName()}");
            }

            if ($result->isDraw()) {
                $output->writeln('<info>Game is a tie</info>');
            }

            $game->render(new ConsoleDisplay($output));
        }
    }
}
 