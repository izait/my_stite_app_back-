<?php

namespace App\Command;

use App\Services\UserService\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowUsers extends Command
{
    /**
     * SimplePasswordForDomophone constructor.
     * @param EntityManagerInterface $entityManager
     */
    protected static $defaultName = 'app:show_users';

    private $userService;

    public function __construct(EntityManagerInterface $entityManager, UserServiceInterface $userService)
    {
        parent::__construct();
        $this->entityManager = $entityManager;

        $this->userService = $userService;
    }

    protected function configure(): void{}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->userService->getAllUsers();

        $output->writeln(print_r($users));

//        foreach ($users as $user){
////                $userId = $user->getId();
//                $userName = $user->getName();
////                $output->writeln($userId);
//                $output->writeln($userName);
//        }

        $output->writeln('Done!');

        return 0;
    }
}