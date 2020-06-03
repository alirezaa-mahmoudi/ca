<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Chain;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ChainController.
 *
 * @Route("/api/chain")
 */
class ChainController extends AbstractController
{
    /**
     * @Route("/", name="chain_index", methods={"HEAD", "GET"})
     */
    public function index()
    {
        $chains = $this->getDoctrine()->getRepository(Chain::class)->findAll();
        $response = [];
        foreach ($chains as $chain) {
            $response[] = [
                'id' => $chain->getId(),
                'name' => $chain->getName(),
                'url' => $this->generateUrl('chain_show', ['id' => $chain->getId()]),
            ];
        }

        return $this->json($response, 200);
    }

    /**
     * @Route("/{id}", name="chain_show", methods={"HEAD", "GET"},
     * requirements={"id"="\d+"}
     * )
     */
    public function show(Chain $chain)
    {
        $response = $this->getDoctrine()->getRepository(Chain::class)
            ->findHotelByChainId($chain->getId());

        return $this->json($response, 200);
    }
}
