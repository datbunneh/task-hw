<?php

namespace App\Command;

use App\Service\ApiGateway;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsCommand(
    name: 'api:users:post',
    description: 'Post a user',
)]
class ApiUsersPostCommand extends Command
{
    public function __construct(private readonly ApiGateway $apiGateway)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'User name')
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            ->addArgument('parentGroup', InputArgument::REQUIRED, 'Parent group identifier');
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        print_r(
            $this->apiGateway->post(
                'users',
                [
                    'name' => $input->getArgument('name'),
                    'email' => $input->getArgument('email'),
                    'parentGroup' => $this->apiGateway->makeIri('groups', (int)$input->getArgument('parentGroup'))
                ]
            )
        );

        return Command::SUCCESS;
    }
}
