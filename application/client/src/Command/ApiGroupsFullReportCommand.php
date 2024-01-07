<?php

namespace App\Command;

use App\Service\ApiGateway;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsCommand(
    name: 'api:groups:full-report',
    description: 'Get full report on user groups',
)]
class ApiGroupsFullReportCommand extends Command
{
    public function __construct(private readonly ApiGateway $apiGateway)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
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
            $this->apiGateway->request(
                Request::METHOD_GET,
                "{$this->apiGateway->getApiHost()}/{$this->apiGateway->getApiPrefix()}/groups/full-report"
            )
        );

        return Command::SUCCESS;
    }
}
