<?php

namespace App\Command;

use App\Entity\Streets;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class DelStreet extends Command
{
    /**
     * SimplePasswordForDomophone constructor.
     * @param EntityManagerInterface $entityManager
     */
    protected static $defaultName = 'app:del_street';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }
    protected function configure(): void{}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $requireStreet=$input->getArgument('Street name');

        $output->writeln($requireStreet);

        /** @var Streets[] $street */
        $street = $this
            ->entityManager
            ->getRepository(Streets::class)
            ->findOneBy([
                'name' => $requireStreet
            ]);

        if ($street === NULL){

            $output->writeln('Улица не найдена!');
            return Command::FAILURE;
        } else {
            $this->entityManager->remove($street);
            $this->entityManager->flush();

            $output->writeln('Улица удалена!');
            return Command::SUCCESS;
        }
    }
}