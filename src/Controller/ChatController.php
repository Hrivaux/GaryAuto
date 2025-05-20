<?php

declare(strict_types=1);

namespace App\Controller;

use OpenAI\Client as OpenAiClient; // on gardera cette import si on veut typer
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    private OpenAiClient $openAi;

    public function __construct()
    {
        // instanciation via la méthode statique client()
        $apiKey = $_ENV['OPENAI_API_KEY'] ?? '';
        $this->openAi = \OpenAI::client($apiKey);
    }

    #[Route('/botman', name: 'botman_handle', methods: ['POST'])]
    public function handle(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $userText = trim($data['message'] ?? '');
        if ($userText === '') {
            return $this->json(['reply' => 'Veuillez saisir un message.'], 400);
        }

        $resp = $this->openAi->chat()->create([
            'model'    => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Tu es GaryBot, assistant pour entretien automobile.'],
                ['role' => 'user',   'content' => $userText],
            ],
        ]);

        $reply = $resp['choices'][0]['message']['content'] ?? 'Désolé, je n’ai pas de réponse.';
        return $this->json(['reply' => $reply]);
    }

    #[Route('/botman/chat', name: 'botman_chat', methods: ['GET'])]
    public function chat()
    {
        return $this->render('botman/chat.html.twig');
    }
}
