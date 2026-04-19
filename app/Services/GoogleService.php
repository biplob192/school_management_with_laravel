<?php

namespace App\Services;

use Exception;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleService
{
    public function __construct(
        private AuthRepository $authRepository,
    ) {}

    public function redirectToGoogle($request)
    {
        try {
            $clientID            = config('services.google.client_id');
            $clientSecret        = config('services.google.client_secret');
            $redirectUri         = config('services.google.redirect');
            $frontendRedirectUri = config('services.google.frontend_redirect_uri');

            if (!$clientID || !$clientSecret || !$redirectUri || !$frontendRedirectUri) {
                throw new Exception("Google OAuth configuration is missing!", 404);
            }

            if ($request->is('api/*')) {
                return response()->json([
                    'url' => Socialite::driver('google')
                        ->stateless() // Ensure stateless for API
                        ->redirectUrl($frontendRedirectUri)
                        ->redirect()
                        ->getTargetUrl(),
                ]);
            }

            // For web, use default redirect
            return Socialite::driver('google')->redirect();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function handleGoogleCallback($request = null)
    {
        try {
            // Use stateless to avoid session issues in API
            $frontendRedirectUri = config('services.google.frontend_redirect_uri');
            $socialiteDriver = $request?->is('api/*')
                ? Socialite::driver('google')->stateless()->redirectUrl($frontendRedirectUri) // For API
                : Socialite::driver('google'); // For web

            $userData = $socialiteDriver->user();

            // $userData = Socialite::driver('google')->user();
            $user = User::where('google_id', $userData->id)->first();

            if (!$user) {
                $user = User::updateOrCreate(
                    ['email' => $userData->email],
                    [
                        'name' => $request?->is('api/*') ? $userData->getName() : $userData->name,
                        'google_id' => $request?->is('api/*') ? $userData->getId() : $userData->id,
                        // 'password' => encrypt('password')
                        'password' => Hash::make('password')
                    ]
                );

                // Assign defaultRole for the user
                $defaultRole = 'Student';
                if (!Role::where('name', $defaultRole)->exists()) {
                    throw new Exception("'$defaultRole' role does not exist.", 404);
                }

                $user->assignRole($defaultRole);
            }

            // Check for user role
            if (! $user->roles->pluck('name')) {
                throw new Exception("User role not found.", 404);
            }

            // Craete user tokens for API
            if ($request?->is('api/*')) {
                $user = $this->authRepository->setUserToken($user);
            } else {
                Auth::login($user);
            }

            return ['data' => $user, 'message' => 'Login successfully.', 'status' => 200];
        } catch (Exception $e) {
            dd($e->getMessage());
            throw new Exception($e->getMessage(), $e->getCode() ?? 500);
        }
    }
}
