<?php

namespace App\Controller;

use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PokemonController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/recherche', name: 'search')]
    public function index(Request $request, PokemonRepository $pokemonRepository): Response
    {
        $search_id = $request->query->get('id');


        if ($search_id) {
            $pokemon = $pokemonRepository->find($search_id);
            if ($pokemon) {

                return $this->redirectToRoute('pokemon_show', ['id' => $search_id]);
            } else {
                $errorMessage = "Aucun Pokémon trouvé pour l'ID " . $search_id;
            }
        }


        return $this->render('pokemon/search.html.twig', [
            'search_id' => $search_id,
            'error_message' => $errorMessage ?? null,
        ]);
    }

    #[Route('/pokemon/{id}', name: 'pokemon_show')]
    public function show($id, PokemonRepository $pokemonRepository): Response
    {

        $pokemon = $pokemonRepository->find($id);

        if (!$pokemon) {

            $errorMessage = "Aucun Pokémon trouvé pour l'ID " . $id;
        } else {
            $errorMessage = null;
        }


        return $this->render('pokemon/show.html.twig', [
            'pokemon' => $pokemon,
            'error_message' => $errorMessage,
        ]);
    }
}
