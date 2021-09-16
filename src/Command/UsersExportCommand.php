<?php

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UsersExportCommand extends Command
{
    protected static $defaultName = 'app:users:export';
    protected static $defaultDescription = 'Add a short description for your command';

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    protected function configure(): void
    {
        $this->addOption(
            'dry',
            null,
            InputOption::VALUE_NONE,
            'show user content'
        );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);
        // $arg1 = $input->getArgument('arg1');

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     $io->writeln(sprintf("You've parsed option1: %s", $input->getOption('option1')));
        // }
        $users = $this->userRepository->findAll();
        if ($input->getOption('dry')) {
            
            $table = new Table($output);
            $table->setHeaders(['id', 'email', 'name']);

            foreach ($users as $user) {
                $table->addRow([
                    $user->getId(),
                    $user->getEmail(),
                    $user->getName(),
                ]);
            }

            $table->render();
            return Command::SUCCESS;
        }

        $jsonData = [];

        foreach ($users as $user) {
            $jsonData[] =[
                $user->getId(),
                $user->getEmail(),
                $user->getName(),
            ];
        }

        file_put_contents('users.json', json_encode($jsonData));
        $io->success("File users.json created in root folder");
        return Command::SUCCESS;
    }
}
