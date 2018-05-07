<?php

namespace PostBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ArchivePostsCommand
 */
class ArchivePostsCommand extends ContainerAwareCommand
{
    /**
     * ArchivePostsCommand constructor.
     * @param null|string $name
     */
    public function __construct(?string $name = null)
    {
        parent::__construct($name);
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('post:archive')
            ->setDescription('Archive posts that expires')
            ->addArgument('argument', InputArgument::REQUIRED, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_REQUIRED, 'Option description')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument('argument');

        $flag = $this->getContainer()->get('post.archive')->archiveMany($argument);
        if ($flag) {
            $output->writeln('Success');
        } else {
            $output->writeln('No posts to archive');
        }
    }
}
