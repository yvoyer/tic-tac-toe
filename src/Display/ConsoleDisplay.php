<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Display;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConsoleDisplay
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Display
 */
class ConsoleDisplay implements Display
{
    /**
     * @var \Symfony\Component\Console\Output\ConsoleOutput
     */
    private $output;

    /**
     * @var array
     */
    private $rows = array();

    /**
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output = null)
    {
        if (null === $output) {
            $output = new ConsoleOutput();
        }

        $this->output = $output;
    }

    private function setCellContent($row, $col, $token)
    {
        if (empty($token)) {
            $token = ' ';
        }

        $this->rows[$row][$col] = $token;
    }

    private function getCellContent($row, $col)
    {
        return $this->rows[$row][$col];
    }

    public function setNorthWestCell($token)
    {
        $this->setCellContent(1, 1, $token);
    }

    public function setWestCell($token)
    {
        $this->setCellContent(2, 1, $token);
    }

    public function setSouthWestCell($token)
    {
        $this->setCellContent(3, 1, $token);
    }

    public function setNorthCell($token)
    {
        $this->setCellContent(1, 2, $token);
    }

    public function setCenterCell($token)
    {
        $this->setCellContent(2, 2, $token);
    }

    public function setSouthCell($token)
    {
        $this->setCellContent(3, 2, $token);
    }

    public function setNorthEastCell($token)
    {
        $this->setCellContent(1, 3, $token);
    }

    public function setEastCell($token)
    {
        $this->setCellContent(2, 3, $token);
    }

    public function setSouthEastCell($token)
    {
        $this->setCellContent(3, 3, $token);
    }

    public function render()
    {
        $gridString = <<<GRID
 %s | %s | %s
-----------
 %s | %s | %s
-----------
 %s | %s | %s
GRID;

        $this->output->writeln(
            sprintf(
                $gridString,
                $this->getCellContent(1, 1),
                $this->getCellContent(1, 2),
                $this->getCellContent(1, 3),
                $this->getCellContent(2, 1),
                $this->getCellContent(2, 2),
                $this->getCellContent(2, 3),
                $this->getCellContent(3, 1),
                $this->getCellContent(3, 2),
                $this->getCellContent(3, 3)
            )
        );
    }
}
 