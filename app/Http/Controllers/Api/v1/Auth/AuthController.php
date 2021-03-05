<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Resources\UserResource;
use App\Mail\ForgotPassword;
use App\Models\User;
use App\Rules\PasswordRule;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $credential = $request->validate([
            "email" => ["required", "string", "max:255"],
            "password" => ["required", "string", "max:255"],
        ]);

        dd(1);
        if (!Auth::attempt($credential)) {
            throw new AuthenticationException('Username or password is wrong.');
        }

        $res =  $this->makeRequest("password", $credential['email'], $credential['password']);

        return $this->okWithData($res);
    }

    public function signup(Request $request)
    {
        $data = $request->validate([
            "full_name" => ["required", "string", "max:255"],
            "email" => ["required", "unique:users,email"],
            "password" => ["required", "string"]
        ]);

        $password = $data['password'];
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        $res = $this->makeRequest("password", $data['email'], $password);

        return $this->okWithData($res);
    }

    public function refreshToken(Request $request)
    {
        $request->validate([
            "refresh_token" => ["required", "string"],
        ]);

        return $this->makeRequest("refresh_token");
    }

    public function forgotPasswordCreate(Request $request)
    {
        $request->validate([
            "email" => ["required", "string", "max:255", "exists:users,email"],
        ]);

        $user = User::where("email", request()->email)->firstOrFail();
        $otp = random_int(1000, 9999);

        if (($query = DB::table('user_otp')->where("user_id", $user->id))->first()) {
            $query->update([
                "otp" => bcrypt($otp),
                "expired_at" => now()->addSeconds(90),
            ]);
        } else {
            DB::table("user_otp")->insert([
                "user_id" => $user->id,
                "otp" => bcrypt($otp),
                "expired_at" => now()->addSeconds(90),
            ]);
        }

        Mail::to(request()->email)->send(new ForgotPassword($user->full_name, $otp));

        return $this->okWithMsg("Please check your email to change new password.");
    }

    public function forgotPassword(Request $request)
    {
        $data = $request->validate([
            "otp" => ["required", "integer"],
            "email" => ["required", "exists:users,email"],
            //"new_password" => ["required", "string", new PasswordRule, "confirmed"],
            "new_password" => ["required", "string"],
        ]);

        $user = User::where("email", $data['email'])->firstOrFail();

        $data['user_id'] = $user->id;

        $query = DB::table('user_otp')->where("user_id", $data['user_id']);

        if (!($user_otp = $query->first()))
            throw ValidationException::withMessages(["email" => "The selected email is invalid."]);

        $user = User::findOrFail($user_otp->user_id);

        if (!Hash::check($data['otp'], $user_otp->otp))
            throw ValidationException::withMessages(["otp" => "The selected otp is wrong."]);

        if (Carbon::parse($user_otp->expired_at)->isPast())
            throw ValidationException::withMessages(["otp" => "The selected otp is expired."]);

        $user->update([
            "password" => bcrypt($data['new_password']),
        ]);

        $query->delete();

        return $this->okWithMsg("Password has been successfully changed.");
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            "full_name" => ["required", "string", "max:255"],
        ]);

        $user = curAuth();

        $user->update($data);

        return $this->updated(new UserResource($user));
    }

    // public function deleteAccount(Request $request)
    // {
    //     $request->validate([
    //         "password" => ["required", "string", "max:255"],
    //     ]);

    //     $user = curAuth();

    //     if (!Hash::check(request()->password, $user->password))
    //         throw new AuthenticationException('The password is wrong.');

    //     $user->delete();

    //     return $this->deleted();
    // }

    public function profile()
    {
        $user = curAuth();

        return $this->okWithData(new UserResource($user));
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            "old_password" => ["required", "string"],
            "new_password" => ["required", "string", new PasswordRule, "confirmed"],
        ]);

        $user = curAuth();

        if (!Hash::check($data['old_password'], $user->password))
            throw ValidationException::withMessages(["old_password" => "The password is incorrect"]);

        $user->update(["password" => bcrypt($data['new_password'])]);

        return $this->updated();
    }

    private function makeRequest($grant_type, $email = null, $password = null)
    {
        $credential = [
            'client_id' => env("PASSPORT_CLIENT_ID"),
            'client_secret' => env("PASSPORT_CLIENT_SECRET"),
        ];

        if ($grant_type === 'refresh_token') {
            $credential = array_merge($credential, [
                "grant_type" => $grant_type,
                "refresh_token" => request()->refresh_token,
            ]);
            $message = "Refresh Token is invalid.";
        } else {
            $credential = array_merge($credential, [
                'grant_type' => $grant_type,
                'username' => $email,
                'password' => $password,
            ]);
            $message = "Username or Password is wrong.";
        }

        $request = Request::create('oauth/token', 'POST', $credential, [], [], [
            'HTTP_Accept' => 'application/json',
        ]);

        $response = app()->handle($request);
        $body = json_decode($response->getContent(), true);
        if ($response->getStatusCode() !== 200)
            throw new AuthenticationException($message);

        //request()->headers->set('Access-Control-Allow-Origin', '*');
        request()->headers->set('Authorization', 'Bearer ' . $body['access_token']);

        return $body;
    }
}
