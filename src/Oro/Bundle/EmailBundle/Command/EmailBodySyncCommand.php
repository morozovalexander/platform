<?php

namespace Oro\Bundle\EmailBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Oro\Bundle\EmailBundle\Cache\EmailCacheManager;
use Oro\Bundle\EmailBundle\Exception\LoadEmailBodyException;

class EmailBodySyncCommand extends ContainerAwareCommand
{
    /**
     * {@internaldoc}
     */
    protected function configure()
    {
        $this
            ->setName('oro:email:body-sync')
            ->setDescription('Synchronization email body')
            ->addOption(
                'id',
                null,
                InputOption::VALUE_REQUIRED,
                'The identifier of email to be synchronized.'
            );
    }

    /**
     * {@internaldoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EmailCacheManager $emailCacheManager */
        $emailCacheManager = $this->getContainer()->get('oro_email.email.cache.manager');

        $emailId = $input->getOption('id');
        $email = $this->getContainer()->get("doctrine")->getRepository('OroEmailBundle:Email')->find($emailId);
        if ($email) {
            try {
                $emailCacheManager->ensureEmailBodyCached($email);
            } catch (LoadEmailBodyException $e) {
                // log
            }
        } else {
            // s
        }
    }
}
