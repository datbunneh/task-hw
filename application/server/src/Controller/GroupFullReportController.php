<?php

namespace App\Controller;

use App\Repository\GroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupFullReportController extends AbstractController
{
    #[Route('/api/groups/full-report', name: 'app_group_full_report', methods: ['GET'], priority: 10)]
    public function index(GroupRepository $groupRepository): Response
    {
        $data = [];

        foreach ($groupRepository->findAll() as $group) {
            $users = [];

            foreach ($group->getUsers() as $user) {
                $users[] = "{$user->getEmail()} ({$user->getName()})";
            }

            $data[] = ['name' => $group->getName(), 'users' => $users];
        }

        return $this->json($data);
    }
}
