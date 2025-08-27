<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Transaction;

use App\Http\Requests\UpdateUserInfosRequest;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\TransactionRequest;

class JADBudgetController extends Controller {

    public function index(){
        return view('JADBudgetV2.index');
    }

    /**
     * TESTED
     */
    public function login(LoginRequest $r){
        if (Auth::attempt(["name" => $r->login, "password" => $r->password])) {
            return response()->json([
                "logged" => "1"
            ], 200);
        }

        return response()->json([], 401);
    }

    /**
     * TESTED
     */
    public function signin(SigninRequest $r){
        User::create([
            "name" => $r->name,
            "email" => $r->email,
            "password" => Hash::make($r->password)
        ]);

        return response()->json([
            "error" => "0",
            "signed" => "1",
            "name" => $r->name,
            "email" => $r->email
        ], 200);
    }

    /**
     * TESTED
     */
    public function dashboard(Request $r){
        return view('JADBudgetV2.dashboard');
    }

    /**
     * TESTED
     */
    public function profile(Request $r){
        return view('JADBudget.profile', [
            'path' => (str_contains(env('APP_URL'), "localhost") ? "storage/" : "public/storage/")
        ]);
    }

    /**
     * TESTED
     */
    public function getUserInfos(Request $r){
        $user = Auth::user();
        
        return response()->json([
            "userName" => $user->name,
            "userEmail" => $user->email,
        ], 200);
    }

    public function getLastConnectionTime(Request $r){
        return response()->json([
            "lastLoginTime" => Auth::user()->last_login_at->diffForHumans()
        ], 200);
    }

    /**
     * TESTED
     */
    public function disconnect(Request $r){
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect('/JADBudgetV2');
    }

    /** TESTED */
    public function getTransactionByType(Request $r){
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)->where('type', $r->type)->get();
        $transactionList = [];

        foreach($transactions as $e){
            array_push($transactionList, [$e->id, $e->label, $e->amount]);
        }

        return response()->json([
            "transactionList" => $transactionList
        ], 200);
    }

    /**
     * TESTED
     */
    public function addTransaction(TransactionRequest $r){
        $user = Auth::user();

        $transaction = Transaction::create([
            "user_id" => $user->id,
            "transaction_app_id" => 0,
            "label" => $r->label,
            "amount" => $r->amount,
            "type" => strtoupper($r->type)
        ]);

        return response()->json([
            "error" => "0",
            "transaction" => $transaction,
            "id" => $transaction->id,
            "label" => $transaction->label,
            "amount" => $transaction->amount
        ], 200);
    }

    /**
     * TESTED
     */
    public function deleteTransaction(Request $r){
        $user = Auth::user();
        $transaction = Transaction::where('id', $r->transaction_id)
                ->where('user_id', $user->id)
                ->firstOrFail();
        
        $transaction->delete();

        return response()->json([
            "id" => $r->transaction_id,
            "transaction_label" => $transaction->label
        ], 200);
    }

    /**
     * TESTED
     */
    public function updateUserInfos(UpdateUserInfosRequest $r){
        $user = Auth::user();

        if (!Hash::check($r->password, $user->password)){
            return response()->json([
                "message" => "Mauvais mot de passe"
            ], 401);
        }

        if ($user->name != $r->name && User::where('name', $r->name)->where('id', '!=', $user->id)->exists())
            return response()->json([
                "message" => "Vous ne pouvez pas utiliser ce nom d'utilisateur."
            ], 401);
        
        if ($user->email != $r->email && User::where('email', $r->email)->where('id', '!=', $user->id)->exists())
            return response()->json([
                "message" => "Vous ne pouvez pas utiliser cet e-mail."
            ], 401);

        $user->name = $r->name;
        $user->email = $r->email;
        $user->save();

        return response()->json([
            "updated" => "1",
            "username" => $user->name,
            "useremail" => $user->email
        ], 200);
    }

    /**
     * TESTED
     */
    public function updatePassword(Request $r){
        $user = Auth::user();
        $password = $r->oldPassword;
        $newPassword = Hash::make($r->newPassword);

        if (!Hash::check($password, $user->password))
            return response()->json([
                "message" => "L'ancien mot de passe est incorrect"
            ], 401);
        
        $user->password = $newPassword;
        $user->save();
        
        return response()->json([
            "updated" => "1"
        ], 200);
    }
}