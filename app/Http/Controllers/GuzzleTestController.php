<?php

namespace App\Http\Controllers;

use App\Services\OpenAIService;

class GuzzleTestController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function test()
    {
        $models = $this->openAIService->getModels();
        
        if (isset($models['error'])) {
            return response("Error: " . $models['error']);
        }

        return response()->json($models);
    }
}
