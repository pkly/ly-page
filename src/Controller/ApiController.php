<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Media\ApiLink;
use App\Entity\Media\MascotGroup;
use App\Entity\Rss\Result;
use App\Mascot\MascotProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    #[Route('/mascot/get/{clientIdentifier}', methods: ['GET'])]
    public function mascotApi(
        MascotProvider $provider,
        string $clientIdentifier
    ): Response {
        $link = $this->em->getRepository(ApiLink::class)->findOneBy(['userIdentifier' => $clientIdentifier]);

        if (null === $link) {
            if (null === ($group = $this->em->getRepository(MascotGroup::class)->findOneBy([]))) {
                return new Response(status: 412);
            }

            $link = new ApiLink()
                ->setUserIdentifier($clientIdentifier)
                ->setMascotGroup($group);

            $this->em->persist($link);
            $this->em->flush();
        }

        return $this->json($provider->get($link->getMascotGroup()));
    }

    #[Route('/mascot/set-group/{clientIdentifier}/{group}', methods: ['POST'])]
    public function setGroup(
        string $clientIdentifier,
        #[MapEntity(mapping: ['group' => 'id'])] MascotGroup $group
    ): Response {
        $link = $this->em->getRepository(ApiLink::class)->findOneBy(['userIdentifier' => $clientIdentifier])
            ?? new ApiLink()
                ->setUserIdentifier($clientIdentifier);

        $link->setMascotGroup($group);
        $this->em->persist($link);
        $this->em->flush();

        return new Response();
    }

    #[Route('/mascot/get-groups', methods: ['GET'])]
    public function getGroups(): Response
    {
        return $this->json($this->em->getRepository(MascotGroup::class)->findAll(), context: ['groups' => 'api']);
    }

    #[Route('/proxy/{file}', name: 'front.file_proxy')]
    public function proxy(
        Result $file,
        HttpClientInterface $client,
    ): Response {
        $response = $client->request('GET', $file->getUrl());

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            return new Response('Failed to download file', 500);
        }

        $file->setSeenAt(new \DateTimeImmutable());

        $this->em->persist($file);
        $this->em->flush();

        return $this->download($response->getContent(), 'file-'.$file->getId().'.torrent', $response->getHeaders()['content-type'][0] ?? 'text/plain');
    }

    protected function download(
        string $contents,
        string $filename,
        string $mime = 'text/plain',
        string $disposition = ResponseHeaderBag::DISPOSITION_ATTACHMENT
    ): Response {
        $response = new Response();
        $ext = explode('.', $filename);

        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-Type', $mime);
        $response->headers->set(
            'Content-Disposition',
            $response->headers->makeDisposition($disposition, $filename, 'file.'.$ext[count($ext) - 1])
        );

        $response->setContent($contents);

        return $response;
    }
}
