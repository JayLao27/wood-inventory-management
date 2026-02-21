<?php

namespace App\Http\Captcha;

use AltchaOrg\Altcha\Altcha;
use AltchaOrg\Altcha\ChallengeOptions;
use Illuminate\Support\Str;

class AltchaService
{
    protected string $hmacKey;
    protected Altcha $altcha;

    public function __construct()
    {
        // Use the key from .env or a default
        $this->hmacKey = env('ALTCHA_HMAC_KEY', '67ac8b56d3b34db7a5fb1f6a6c7e9d2f');
        $this->altcha = new Altcha($this->hmacKey);
    }

    /**
     * Creates a "Code Captcha" challenge where the user must type the text from an image.
     */
    public function createCodeChallenge()
    {
        // 1. Generate a random numeric code (must be integer)
        $code = rand(100000, 999999);
        $salt = bin2hex(random_bytes(12));
        $expires = (new \DateTimeImmutable())->add(new \DateInterval('PT1M')); // 1 minute
        
        // 2. Create the Altcha challenge using CheckChallengeOptions
        // This is the cleanest way to specify a number and salt.
        $options = new \AltchaOrg\Altcha\CheckChallengeOptions(
            algorithm: \AltchaOrg\Altcha\Hasher\Algorithm::SHA256,
            salt: $salt,
            number: $code
        );
        
        // Add expiration manually since CheckChallengeOptions doesn't take it in constructor
        // but its parent BaseChallengeOptions allows it (via $expires property)
        // Actually, we can just use BaseChallengeOptions for full control
        $options = new \AltchaOrg\Altcha\BaseChallengeOptions(
            algorithm: \AltchaOrg\Altcha\Hasher\Algorithm::SHA256,
            maxNumber: 1000000,
            expires: $expires,
            salt: $salt,
            number: $code,
            params: []
        );
        
        $challenge = $this->altcha->createChallenge($options);
        
        // 3. Generate the SVG image of the code
        $image = $this->generateSvg((string)$code);
        
        // 4. Return as an array for JSON response
        // IMPORTANT: We nest the image inside 'codeChallenge' for Altcha v2 manual mode.
        // And set 'maxnumber' to 0 to explicitly disable automatic PoW solving.
        return [
            'algorithm' => $challenge->algorithm,
            'challenge' => $challenge->challenge,
            'salt'      => $challenge->salt,
            'signature' => $challenge->signature,
            'maxnumber' => 0,
            'codeChallenge' => [
                'image' => 'data:image/svg+xml;base64,' . base64_encode($image),
            ],
        ];
    }

    /**
     * Generates a noisy SVG image for the CAPTCHA text.
     */
    private function generateSvg($code)
    {
        $width = 300;
        $height = 100;
        
        $svg = '<svg width="' . $width . '" height="' . $height . '" xmlns="http://www.w3.org/2000/svg">';
        
        // Background with slight texture
        $svg .= '<rect width="100%" height="100%" fill="#f8f9fa" />';
        
        // Noise: Random lines
        for ($i = 0; $i < 12; $i++) {
            $x1 = rand(0, $width);
            $y1 = rand(0, $height);
            $x2 = rand(0, $width);
            $y2 = rand(0, $height);
            $color = sprintf('#%06X', mt_rand(0xAAAAAA, 0xDDDDDD));
            $svg .= '<line x1="' . $x1 . '" y1="' . $y1 . '" x2="' . $x2 . '" y2="' . $y2 . '" stroke="' . $color . '" stroke-width="1" />';
        }
        
        // The Code Characters
        $chars = str_split($code);
        $x_pos = 30;
        foreach ($chars as $char) {
            $rotate = rand(-15, 15);
            $y_pos = rand(65, 75);
            $fontSize = rand(38, 46);
            $svg .= '<text x="' . $x_pos . '" y="' . $y_pos . '" font-family="Monospace, Courier New" font-weight="bold" font-size="' . $fontSize . '" fill="#2d3436" transform="rotate(' . $rotate . ',' . $x_pos . ',' . $y_pos . ')">' . $char . '</text>';
            $x_pos += 40;
        }

        // Noise: Random dots on top
        for ($i = 0; $i < 40; $i++) {
            $x = rand(0, $width);
            $y = rand(0, $height);
            $svg .= '<circle cx="' . $x . '" cy="' . $y . '" r="1"' . (rand(0,1) ? ' fill="#333"' : ' fill="#ccc"') . ' />';
        }
        
        $svg .= '</svg>';
        
        return $svg;
    }

    /**
     * Verifies the solution provided by the user.
     */
    public function verify($payload)
    {
        if (is_string($payload)) {
            $payload = json_decode(base64_decode($payload), true);
        }

        if (!$payload) {
            \Log::error('Altcha: Empty or invalid payload');
            return false;
        }

        // Add integer casting for the code challenge (the library requires int)
        if (isset($payload['number'])) {
            $payload['number'] = (int) $payload['number'];
        }

        // Log attempt for debugging
        \Log::debug('Altcha: Verification attempt', ['payload' => $payload]);

        $ok = $this->altcha->verifySolution($payload);

        if (!$ok) {
            \Log::warning('Altcha: Verification failed for payload', ['payload' => $payload]);
        }

        return $ok;
    }
}