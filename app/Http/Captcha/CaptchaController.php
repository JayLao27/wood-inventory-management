<?php

namespace App\Http\Captcha;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Captcha\AltchaService;

class CaptchaController extends Controller
{
    protected $altchaService;

    public function __construct(AltchaService $altchaService)
    {
        $this->altchaService = $altchaService;
    }

    /**
     * Endpoint for the Altcha widget to get a "Code" challenge.
     */
    public function challenge()
    {
        $challenge = $this->altchaService->createCodeChallenge();
        return response()->json($challenge);
    }
}
