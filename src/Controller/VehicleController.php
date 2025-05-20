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
public function index(Request $request, VehicleRepository $vehicleRepository, HttpClientInterface $client, EntityManagerInterface $em): Response
{
    $form = $this->createFormBuilder()
        ->add('recherche', TextType::class, [
            'label' => false,
            'required' => true,
        ])
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        $input = strtoupper(str_replace([' ', '-'], '', $data['recherche'] ?? ''));

        if (empty($input)) {
            $this->addFlash('error', 'Veuillez entrer une plaque ou un VIN.');
            return $this->redirectToRoute('app_vehicle');
        }

        $isVin = strlen($input) >= 17;

        $url = $isVin
            ? 'https://api.apiplaqueimmatriculation.com/vin'
            : 'https://api.apiplaqueimmatriculation.com/plaque';

        $params = $isVin
            ? ['vin' => $input, 'token' => 'TokenDemo2025A']
            : ['immatriculation' => $input, 'token' => 'TokenDemo2025A', 'pays' => 'FR'];

        try {
            $method = 'GET'; // 👉 Toujours GET, même pour VIN

            $response = $client->request($method, $url, [
                'query' => $params,
                'proxy' => null,
            ]);


            $apiData = $response->toArray()['data'] ?? null;
            
            if (!$apiData) {
                $this->addFlash('error', 'Réponse vide de l’API.');
                return $this->redirectToRoute('app_vehicle');
            }

            if (!empty($apiData['erreur'])) {
                $this->addFlash('error', 'Erreur API : ' . $apiData['erreur']);
                return $this->redirectToRoute('app_vehicle');
            }


            $vehicle = new Vehicle();
            $vehicle->setUser($this->getUser());
            $vehicle->setImmat($apiData['immat'] ?? $input);
            $vehicle->setMarque($apiData['marque']);
            $vehicle->setModele($apiData['modele']);
            $vehicle->setDateMiseEnCirculation(new \DateTime($apiData['date1erCir_us']));
            $vehicle->setEnergie($apiData['energieNGC'] ?? null);
            $vehicle->setCo2((int)($apiData['co2'] ?? 0));
            $vehicle->setPuissanceFiscale((int)($apiData['puisFisc'] ?? 0));
            $vehicle->setPuissanceReelle((int)($apiData['puisFiscReelCH'] ?? 0));
            $vehicle->setCarrosserie($apiData['carrosserieCG'] ?? null);
            $vehicle->setBoiteVitesse($apiData['boite_vitesse'] ?? null);
            $vehicle->setNbPassagers((int)($apiData['nr_passagers'] ?? 0));
            $vehicle->setNbPortes((int)($apiData['nb_portes'] ?? 0));
            $vehicle->setNomCommercial($apiData['sra_commercial'] ?? null);
            $vehicle->setVin($apiData['vin'] ?? $input);
            $vehicle->setCouleur($apiData['couleur'] ?? null);
            $vehicle->setLogoMarque($apiData['logo_marque'] ?? null);

            $em->persist($vehicle);
            $em->flush();

            $this->addFlash('success', 'Véhicule ajouté avec succès.');
            return $this->redirectToRoute('app_vehicle');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Erreur lors de la récupération du véhicule.');
            return $this->redirectToRoute('app_vehicle');
        }
    }

    $vehicles = $vehicleRepository->findBy(['user' => $this->getUser()]);
    $missingKm = array_filter($vehicles, fn($v) => $v->getKilometres() === null);


    return $this->render('vehicle/index.html.twig', [
        'vehicles' => $vehicles,
        'form' => $form->createView(),
        'missingKm' => $missingKm,
    ]);
}

#[Route('/vehicle/{id}/update-km', name: 'app_vehicle_update_km', methods: ['POST'])]
public function updateKm(Request $request, Vehicle $vehicle, EntityManagerInterface $em): Response
{
    $kilometres = (int) $request->request->get('kilometres');

    if ($kilometres > 0) {
        $vehicle->setKilometres($kilometres);
        $em->flush();
        $this->addFlash('success', 'Kilométrage mis à jour avec succès.');
    } else {
        $this->addFlash('error', 'Le kilométrage doit être supérieur à 0.');
    }

    return $this->redirectToRoute('app_vehicle');
}


}
