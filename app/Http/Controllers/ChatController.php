<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatBrainService; // Usamos el ChatBrainService
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    protected $chatBrainService;

    public function __construct(ChatBrainService $chatBrainService)
    {
        $this->chatBrainService = $chatBrainService;
    }

    public function index()
    {
        return view('chat');
    }

    public function send(Request $request)
    {
        $userMessage = $request->input('message');

        try {
            // Usamos el ChatBrainService para procesar la consulta
            $respuesta = $this->chatBrainService->procesarConsulta($userMessage);

            return response()->json([
                'reply' => $respuesta,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al procesar la consulta: ' . $e->getMessage());
            return response()->json([
                'reply' => 'Error al responder.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
