<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class MainContoller extends Controller
{

    public function index() {
        return view('welcome');
    }

    public function login(Request $request)
    {
        // following code borrowed from https://github.com/jumbojett/OpenID-Connect-PHP/blob/master/src/OpenIDConnectClient.php#L779
        $codeVerifier = bin2hex(random_bytes(64));
        $codeChallenge = rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');
        $state = \bin2hex(\random_bytes(16));

        session()->put('openid_connect_code_verifier', $codeVerifier);

        $authorizeUrl = env('SUBRITE_ID_AUTHORIZATION_ENDPOINT') ;
        
        // replace the url with actual url that you set in subrite admin portal
        $redirectUri = 'http://localhost:3010/api/auth/callback';

        $query = [
            'client_id' => env('OAUTH_CLIENT_ID'),
            'response_type' => 'code',
            'scope' => 'openid offline_access',
            'redirect_uri' => $redirectUri,
            'code_challenge' => $codeChallenge,
            'code_challenge_method' => 'S256', // requred as have PKCE support enabled
            'state' => $state,
        ];

        $url = $authorizeUrl . '?' . http_build_query($query);

        return redirect()->away($url);
    }

    public function callback(Request $request) {
        $tokenEndpoint = env('SUBRITE_ID_TOKEN_ENDPOINT');
        $code = $request->get('code');
        $codeVerifier = session()->get('openid_connect_code_verifier');

        $response = Http::asForm()->post($tokenEndpoint, [
            'code' => $code,
            'grant_type' => 'authorization_code',
            'client_id' => env('OAUTH_CLIENT_ID'),
            'client_secret' => env('OAUTH_CLIENT_SECRET'),
            'code_verifier' => $codeVerifier,
        ]);

        session()->forget('openid_connect_code_verifier');

        return $response->json();
    }
}
