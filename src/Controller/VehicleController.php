<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\HttpClientInterface;


final class VehicleController extends AbstractController
{
    #[Route('/vehicle', name: 'app_vehicle')]
   #[Route('/vehicle', name: 'app_vehicle')]
public function index(VehicleRepository $vehicleRepository): Response
{
    $user = $this->getUser();

    $vehicles = $vehicleRepository->findBy(['user' => $user]);

    return $this->render('vehicle/index.html.twig', [
        'vehicles' => $vehicles,
    ]);
}


    #[Route('/vehicle/add', name: 'app_vehicle_add')]
    #[Route('/vehicle/add', name: 'app_vehicle_add')]
public function add(Request $request, HttpClientInterface $client, EntityManagerInterface $em): Response
{
    $form = $this->createFormBuilder()
        ->add('immat', TextType::class, [
            'label' => 'Plaque d’immatriculation',
            'attr' => ['class' => 'w-full p-2 border border-gray-300 rounded-lg']
        ])
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $immat = strtoupper(str_replace([' ', '-'], '', $form->get('immat')->getData()));

        // Appel en GET avec proxy désactivé
        $response = $client->request('GET', 'https://api.apiplaqueimmatriculation.com/plaque', [
            'query' => [
                'immatriculation' => $immat,
                'token' => 'TokenDemo2025A',
                'pays' => 'FR',
            ],
            'proxy' => null
        ]);

        $data = $response->toArray()['data'] ?? null;

        if (!$data || isset($data['erreur']) && $data['erreur'] !== '') {
            $this->addFlash('error', 'Véhicule introuvable ou erreur API.');
            return $this->redirectToRoute('app_vehicle_add');
        }

        $vehicle = new Vehicle();
        $vehicle->setUser($this->getUser());
        $vehicle->setImmat($data['immat']);
        $vehicle->setMarque($data['marque']);
        $vehicle->setModele($data['modele']);
        $vehicle->setDateMiseEnCirculation(new \DateTime($data['date1erCir_us']));
        $vehicle->setEnergie($data['energieNGC'] ?? null);
        $vehicle->setCo2((int)($data['co2'] ?? 0));
        $vehicle->setPuissanceFiscale((int)($data['puisFisc'] ?? 0));
        $vehicle->setPuissanceReelle((int)($data['puisFiscReelCH'] ?? 0));
        $vehicle->setCarrosserie($data['carrosserieCG'] ?? null);
        $vehicle->setBoiteVitesse($data['boite_vitesse'] ?? null);
        $vehicle->setNbPassagers((int)($data['nr_passagers'] ?? 0));
        $vehicle->setNbPortes((int)($data['nb_portes'] ?? 0));
        $vehicle->setNomCommercial($data['sra_commercial'] ?? null);
        $vehicle->setVin($data['vin'] ?? null);
        $vehicle->setCouleur($data['couleur'] ?? null);
        $vehicle->setLogoMarque($data['logo_marque'] ?? null);

        $em->persist($vehicle);
        $em->flush();

        $this->addFlash('success', 'Véhicule ajouté avec succès.');
        return $this->redirectToRoute('app_vehicle');
    }

    return $this->render('vehicle/add.html.twig', [
        'form' => $form->createView(),
    ]);
}
}
