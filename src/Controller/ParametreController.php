<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ParametreUser;

use App\Entity\User;
final class ParametreController extends AbstractController
{
 #[Route('/parametre', name: 'app_parametre')]
public function index(Request $request, EntityManagerInterface $em): Response
{
    $user = $this->getUser();

    // Cherche les paramètres existants ou en crée un nouveau
    $param = $em->getRepository(ParametreUser::class)->findOneBy(['user' => $user]) ?? new ParametreUser();
    $param->setUser($user);

    if ($request->isMethod('POST')) {
        $param->setSiteColor($request->request->get('site_color'))
            ->setFont($request->request->get('font'))
            ->setLayoutWidth($request->request->get('layout_width'))
            ->setLogoUrl($request->request->get('logo_url'))
            ->setDarkMode($request->request->getBoolean('dark_mode'))
            ->setShowFooter($request->request->getBoolean('show_footer'))
            ->setButtonStyle($request->request->get('button_style'));

        $em->persist($param);
        $em->flush();

        $this->addFlash('success', 'Paramètres enregistrés.');
    }

    return $this->render('parametre/index.html.twig', [
        'param' => $param
    ]);
}


}
