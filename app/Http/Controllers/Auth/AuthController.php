<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpCodeMail;
use App\Models\OtpCode;
use Carbon\Carbon;

class AuthController extends Controller
{

 public function loginForm()
    {
        return view("admins.auth.login");
    }


    /**
     * Étape 1 : Connexion avec email + mot de passe
     */
    public function login(LoginRequest $request)
    {
        // 1. Valider les données
        $data = $request->validated();

        // 2. Vérifier si l'utilisateur existe
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return redirect()->route('loginForm')->with('error', 'Email incorrect.')->withInput();
        }

        // 3. Vérifier le mot de passe
        if (!Hash::check($data['password'], $user->password)) {
            return redirect()->route('loginForm')->with('error', 'Mot de passe incorrect.')->withInput();
        }

        // 4. Générer un code OTP
        $code = rand(111111, 999999);
        
        OtpCode::where('email', $data['email'])->delete();
        
        OtpCode::create([
            'email' => $data['email'],
            'code' => Hash::make($code),
        ]);

        // 5. Envoyer le code par email
        Mail::to($data['email'])->send(new OtpCodeMail( $data['email'], $code));

        // 6. Stocker l'email en session pour l'étape 2
        session()->put('otp_email', $data['email']);

        // 7. Rediriger vers la page de vérification OTP
        return redirect()->route('otp.verify.form')
                         ->with('success', 'Un code OTP vous a été envoyé par email.');
    }

    /**
     * Afficher le formulaire de vérification OTP
     */
    public function showOtpForm()
    {
        // Vérifier si l'email est en session
        if (!session()->has('otp_email')) {
            return redirect()->route('loginForm')->with('error', 'Veuillez vous connecter d\'abord.');
        }

        return view('admins.auth.otp-verify');
    }

    /**
     * Étape 2 : Vérification du code OTP
     */
    public function verifyOtp(Request $request)
    {
        // 1. Valider les données
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        // 2. Récupérer l'email depuis la session
        $email = session('otp_email');

        if (!$email) {
            return redirect()->route('home')->with('error', 'Session expirée. Veuillez vous reconnecter.');
        }

        // 3. Vérifier le code OTP
        $otpCode = OtpCode::where('email', $email)->first();

        if (!$otpCode) {
            return redirect()->route('home')->with('error', 'Aucun code OTP trouvé. Veuillez vous reconnecter.');
        }

        // 4. Vérifier l'expiration du code (5 minutes)
        if (Carbon::parse($otpCode->created_at)->addMinutes(5)->isPast()) {
            $otpCode->delete();
            return redirect()->route('home')->with('error', 'Le code OTP a expiré. Veuillez vous reconnecter.');
        }

        // 5. Vérifier si le code est correct
        if (!Hash::check($request->code, $otpCode->code)) {
            return redirect()->route('otp.verify.form')->with('error', 'Code OTP incorrect.');
        }

        // 6. Authentifier l'utilisateur
        $user = User::where('email', $email)->first();
        Auth::login($user);

        // 7. Supprimer le code OTP
        $otpCode->delete();
        session()->forget('otp_email');

        // 8. Rediriger vers le dashboard
        return redirect()->route('admins.dashboard')->with('success', 'Connexion réussie !');
    }

    /**
     * Renvoyer un nouveau code OTP
     */
    public function resendOtp()
    {
        $email = session('otp_email');

        if (!$email) {
            return redirect()->route('home')->with('error', 'Session expirée. Veuillez vous reconnecter.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Utilisateur non trouvé.');
        }

        // Générer un nouveau code
        $code = rand(111111, 999999);
        
        OtpCode::where('email', $email)->delete();
        
        OtpCode::create([
            'email' => $email,
            'code' => Hash::make($code),
        ]);

        Mail::to($email)->send(new OtpCodeMail( $email, $code));

        return redirect()->route('otp.verify.form')
                         ->with('success', 'Un nouveau code OTP vous a été envoyé.');
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        Auth::logout();
        session()->forget('otp_email');
        return redirect()->route('home')->with('success', 'Déconnexion réussie.');
    }
    public function dashboard()
    {
        return view('admins.dashboard');
    }
}