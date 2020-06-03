<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Service\HotelScoreHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/average", name="average", methods={"GET", "HEAD"})
     *
     * @param Request $request
     * @param HotelScoreHandler $handler
     * @return JsonResponse
     */
    public function getAverage(Request $request, HotelScoreHandler $handler)
    {
        $uuid = $request->get('uuid');

        if (is_null($uuid)) {
            throw $this->createNotFoundException('UUID was not specified');
        }

        $score = $handler($uuid);

        return $this->json($score);
    }

    /**
     * @Route("/api/reviews", name="review_list", methods={"GET", "HEAD"})
     *
     * @return JsonResponse
     */
    public function getReviews(Request $request)
    {
        $uuid = $request->get('uuid');

        if (is_null($uuid)) {
            throw $this->createNotFoundException('UUID was not specified');
        }

        $reviews = $this->getDoctrine()->getRepository(Hotel::class)
            ->findAllHotelReviewsByUuid($uuid);

        return $this->json($reviews);
    }

    /**
     * @Route("/api/hotels", name="hotel_list", methods={"GET", "HEAD"})
     *
     * @return JsonResponse
     */
    public function getHotels()
    {
        $entityManager = $this->getDoctrine();
        $hotels = $entityManager->getRepository(Hotel::class)->findAll();
        $result = [];
        foreach ($hotels as $hotel) {
            $result[] = [
                'name' => $hotel->getName(),
                'address' => $hotel->getAddress(),
                'uuid' => $hotel->getUuid(),
                'chain' => $this->generateUrl('chain_show', ['id' => $hotel->getChain()->getId()]),
            ];
        }

        return $this->json($result);
    }

    /**
     * @Route("/widget/{filename}", name="secript_widget",
     *      requirements={
     *     "filename"="[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}.*\.js$"
     *     })
     *
     * @param $filename
     *
     * @param HotelScoreHandler $handler
     *
     * @return Response
     */
    public function widget($filename, HotelScoreHandler $handler)
    {
        $uuid = substr($filename, 0, 36);
        $score = $handler($uuid);
        $renderView = $this->renderView('iframe.js.twig', $score);
        $response = new Response($renderView);
        $response->headers->set('Content-Type', 'text/javascript');

        return $response;
    }
}
