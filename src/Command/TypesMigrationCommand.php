<?php

namespace Softspring\ImageBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Softspring\ImageBundle\Manager\ImageManagerInterface;
use Softspring\ImageBundle\Model\ImageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TypesMigrationCommand extends Command
{
    protected static $defaultName = 'sfs:image:types-migration';

    protected EntityManagerInterface $em;

    protected ImageManagerInterface $imageManager;

    public function __construct(EntityManagerInterface $em, ImageManagerInterface $imageManager)
    {
        parent::__construct();
        $this->em = $em;
        $this->imageManager = $imageManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $images = $this->em->getRepository(ImageInterface::class)->findAll();
        foreach ($images as $image) {

        }
    }
}