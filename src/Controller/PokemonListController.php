<?php

namespace App\Controller;

use App\Repository\PokemonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PokemonListController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, PokemonRepository $pokemonRepository, PaginatorInterface $paginator): Response
    {

        $queryBuilder = $pokemonRepository->createQueryBuilder('p');


        $pagination = $paginator->paginate(
            $queryBuilder, // Requête de base
            $request->query->getInt('page', 1), 8
        );


        return $this->render('pokemon/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
