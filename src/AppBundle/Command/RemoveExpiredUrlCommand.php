<?php
/**
 * Created by PhpStorm.
 * User: sanct
 * Date: 01.02.2018
 * Time: 13:52
 */

namespace AppBundle\Command;

use AppBundle\Entity\Url;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveExpiredUrlCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('urls:expired')
			->setDescription('Delete expired urls(lifetime 15 days)');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$em = $this->getContainer()->get('doctrine')->getManager();
		$urlRepository = $this->getContainer()->get('doctrine')->getRepository(Url::class);
		$expiredUrls = $urlRepository->getExpiredUrls();

		foreach ($expiredUrls as $expired_url){
			$em->remove($expired_url);
		}
		$em->flush();

		$logger = $this->getContainer()->get('logger');
		$message = count($expiredUrls) . ' expired URLs deleted.';

		$logger->info($message);
		$output->writeln($message);
	}
}