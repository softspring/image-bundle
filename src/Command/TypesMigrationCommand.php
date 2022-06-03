<?php

namespace Softspring\ImageBundle\Command;

use Softspring\ImageBundle\Manager\ImageManagerInterface;
use Softspring\ImageBundle\Manager\ImageTypeManagerInterface;
use Softspring\ImageBundle\Manager\ImageVersionManagerInterface;
use Softspring\ImageBundle\Model\ImageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TypesMigrationCommand extends Command
{
    protected static $defaultName = 'sfs:image:types-migration';

    protected ImageManagerInterface $imageManager;
    protected ImageVersionManagerInterface $imageVersionManager;
    protected ImageTypeManagerInterface $typesManager;

    public function __construct(ImageManagerInterface $imageManager, ImageVersionManagerInterface $imageVersionManager, ImageTypeManagerInterface $typesManager)
    {
        parent::__construct();
        $this->imageManager = $imageManager;
        $this->imageVersionManager = $imageVersionManager;
        $this->typesManager = $typesManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $images = $this->imageManager->getRepository()->findAll();

        /** @var ImageInterface $image */
        foreach ($images as $image) {
            $typeConfig = $this->typesManager->getType($image->getType());

            if (!$typeConfig) {
                $output->writeln(sprintf('<error>Image "%s" has an error. Type "%s" has been deleted</error>', $image->getName(), $image->getType()));
                continue;
            }

            $output->writeln(sprintf('Image "%s" of type "%s"', $image->getName(), $image->getType()));

            $checkVersions = $image->checkVersions($typeConfig);

            foreach ($checkVersions['ok'] as $versionId) if ($versionId !== '_original') {
                $output->writeln(sprintf(' - version "%s" is <fg=green>OK</>', $versionId));
            }

            foreach ($checkVersions['new'] as $versionId) {
                $output->write(sprintf(' - version "%s" is new in config, needs to be created: ', $versionId));
                try {
                    $this->imageManager->generateVersion($image, $versionId);
                    $output->writeln('<fg=green>CREATED</>');
                } catch (\Exception $e) {
                    $output->writeln('<error>ERROR</error>');
                }
            }

            foreach ($checkVersions['changed'] as $versionId => $changes) {
                $changedOptionsString = implode(', ', array_map(fn ($v) => $v['string'], $changes));
                $output->write(sprintf(' - version "%s" needs to be recreated (%s): ', $versionId, $changedOptionsString));
                try {
                    $this->imageManager->generateVersion($image, $versionId);
                    $output->writeln('<fg=green>RECREATED</>');
                } catch (\Exception $e) {
                    $output->writeln('<error>ERROR</error>');
                }
            }

            foreach ($checkVersions['delete'] as $versionId) {
                $output->write(sprintf(' - version "%s" to be deleted from database (has been deleted from config) ', $versionId));
                try {
                    $this->imageManager->deleteVersion($image->getVersion($versionId));
                    $output->writeln('<fg=green>DELETED</>');
                } catch (\Exception $e) {
                    $output->writeln('<error>ERROR</error>');
                }
            }

            $output->writeln('');
        }

        return Command::SUCCESS;
    }
}
