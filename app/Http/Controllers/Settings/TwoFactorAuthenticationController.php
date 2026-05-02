<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\TwoFactorAuthenticationRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Features;

class TwoFactorAuthenticationController extends Controller
{
    public function show(TwoFactorAuthenticationRequest $request): Response|RedirectResponse
    {
        $request->ensureStateIsValid();

        // Check if password confirmation is required
        if (Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')) {
            if (! $request->session()->has('auth.password_confirmed_at') ||
                $request->session()->get('auth.password_confirmed_at') < now()->subMinutes(config('auth.password_timeout', 10800))->getTimestamp()) {
                return redirect()->route('password.confirm');
            }
        }

        $recoveryCodes = [];
        if ($request->user()->hasEnabledTwoFactorAuthentication()) {
            $recoveryCodes = $request->user()->recoveryCodes() ?? [];
        }

        return Inertia::render('settings/TwoFactor', [
            'twoFactorEnabled' => $request->user()->hasEnabledTwoFactorAuthentication(),
            'requiresConfirmation' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
            'recoveryCodes' => $recoveryCodes,
        ]);
    }
}
