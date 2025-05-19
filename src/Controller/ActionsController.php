<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActionsController extends AbstractController
{
    #[Route('/entretien', name: 'app_entretien')]
    public function index(): Response
    {
        $pieces = [
            [
                'titre' => 'Batterie',
                'conseil' => 'Vérifie les bornes pour la corrosion. Recharge si faible. Change tous les 4-5 ans.'
            ],
            [
                'titre' => 'Huile moteur',
                'conseil' => 'Vérifie le niveau avec la jauge. Complète ou change tous les 10 000 km.'
            ],
            [
                'titre' => 'Liquide de frein',
                'conseil' => 'Doit être clair et à bon niveau. À changer tous les 2 ans.'
            ],
            [
                'titre' => 'Filtre à air',
                'conseil' => 'Remplace tous les 20 000 km ou plus souvent en milieu poussiéreux.'
            ],
            [
                'titre' => 'Pneus',
                'conseil' => 'Vérifie la pression chaque mois. Contrôle l’usure et remplace si nécessaire.'
            ],
            [
                'titre' => 'Essuie-glaces',
                'conseil' => 'Remplace si traces ou grincements. Idéalement tous les 6 à 12 mois.'
            ],
        ];

        return $this->render('actions/index.html.twig', [
            'pieces' => $pieces
        ]);
    }
}
