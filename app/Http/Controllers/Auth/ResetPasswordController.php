<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'phone' => 'required',
        ];

        $messages = [
            'phone.required' => 'Le N° de téléphone est obligatoire',
        ];

        // Utilisation de $request à la place de Input::all()
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Session::flash('error', 'N° de téléphone est obligatoire');
            return Redirect::to('password.request')
                ->withErrors($validator);
        } else {
            $account = DB::table('espace_perso_account')
                ->where('phone_number', str_replace(" ", "", $request->phone))
                ->first();

            if (!$account) {
                Session::flash('error', 'Aucun compte ne correspond à ce numéro de téléphone');
                return redirect()->back();
            } else {
                $otp = mt_rand(1000, 9999);
                $sms = "CODE OTP DE REINIALISATION DE MOT DE PASSE : \r\n $otp";
                $this->sendOtpSms($sms, $request->phone);
                Session::flash('info', 'Saisissez le code OTP reçu par SMS.');
                Session::put("PIN", $otp);
                Session::put("PHONE", str_replace(" ", "", $request->phone));
                return redirect()->route('password.otp');
            }
        }
    }

    public function optPage()
    {
        if (Session::has("PIN") && Session::has("PHONE")) {
            return view('auth.passwords.otp');
        }

        return redirect()->route('password.request');
    }

    public function checkPin(Request $request)
    {
        $account = DB::table('espace_perso_account')
            ->where('phone_number', Session::get("PHONE"))
            ->first();

        if ($account) {
            if (Session::get("PIN") == str_replace(" ", "", $request->pin)) {
                return redirect()->route('password.reset.page', $account->remember_token);
            } else {
                Session::flash('error', 'Code PIN incorrect');
                return redirect()->back();
            }
        } else {
            Session::flash('error', 'Aucun compte ne correspond à ce numéro de téléphone');
            return redirect()->back();
        }
    }

    public function showResetPasswordPage($remember_token)
    {
        $account = DB::table('espace_perso_account')
            ->where('phone_number', Session::get("PHONE"))
            ->first();

        if ($account) {
            if ($account->remember_token == $remember_token) {
                return view('auth.passwords.resetpassword', compact('account'));
            } else {
                Session::flash('error', 'Mauvais Token : Le token de réinitialisation du mot de passe a expiré');
                return redirect()->route('password.request');
            }
        } else {
            Session::flash('error', 'Aucun compte ne correspond à ce numéro de téléphone');
            return redirect()->route('password.request');
        }
    }

    public function updatePassword(Request $request)
    {
        if (Session::has("PHONE")) {
            $account = DB::table('espace_perso_account')
                ->where('phone_number', Session::get("PHONE"))
                ->update([
                    "password" => bcrypt($request->newpassword),
                    "remember_token" => str_random(60)
                ]);

            if ($request->newpassword != $request->repeatnewpassword) {
                Session::flash('error', 'Les mots de passe ne correspondent pas!');
                return redirect()->back();
            }

            $userdata = [
                'phone_number' => str_replace(" ", "", Session::get("PHONE")),
                'password' => $request->newpassword,
            ];

            if (Auth::guard('space_perso')->attempt($userdata)) {
                Session::flash('success', 'Mot de passe modifié avec succès');
                return redirect()->route('page.myspace')->with(['active' => 'myspace']);
            } else {
                Session::flash('error', 'Le token de réinitialisation du mot de passe a expiré');
                return redirect()->route('password.request');
            }
        } else {
            Session::flash('error', 'Le token de réinitialisation du mot de passe a expiré');
            return redirect()->route('password.request');
        }
    }

    private function sendOtpSms($mon_sms, $phone)
    {
        $sender_id = rawurlencode("220 170 00"); // Nombre de caractères inférieur à 11
        $phone = str_replace(" ", "", $phone);
        $phone = str_replace("-", "", $phone);
        $url = "http://gateway2.arolitec.com/interface/senderv2.php?user=addams&password=wN44vu5Q&sender=" . $sender_id . "&receiver=225" . $phone . "&content=" . urlencode($mon_sms);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "cache-control: no-cache"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
    }
}
