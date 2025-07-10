<?php

namespace App\Controller;

use App\Entity\Rss\Result;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiController extends AbstractController
{
    #[Route('/proxy/{file}', name: 'front.file_proxy')]
    public function proxy(
        Result $file,
        HttpClientInterface $client,
        EntityManagerInterface $em
    ): Response {
        $response = $client->request('GET', $file->getUrl());

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            return new Response('Failed to download file', 500);
        }

        $file->setSeenAt(new \DateTimeImmutable());

        $em->persist($file);
        $em->flush();

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
