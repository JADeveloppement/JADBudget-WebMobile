<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Transaction;

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

    /**
     * TESTED
     */
    public function disconnect(Request $r){
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect('/JADBudgetV2');
    }

    /**
     * TESTED
     */
    public function getTransactions(Request $r){
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)->get();
        $transactionList = [];
        foreach($transactions as $e){
            array_push($transactionList, [$e->id, $e->label, $e->amount, $e->type]);
        }

        return response()->json([
            "user_id" => $user->id,
            "transactionList" => $transactionList
        ], 200);
    }

    /** TODO - Make a test */
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
            "type" => $r->type
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
            "DB label" => $transaction->label
        ], 200);
    }

    public function updateUserInfos(Request $r){
        $user = Auth::user();

        $userToUpdate = Auth::attempt([
            "name" => $user->name,
            "password" => $r->password
        ]);

        if (!$userToUpdate)
            return response()->json([
                "updated" => "-1",
                "message" => "Mauvais mot de passe"
            ], 401);
        
        $userEmail = User::where('email', $r->email)->first();
        $userLogin = User::where('name', $r->login)->first();

        if ($userEmail && $userEmail->id != $user->id)
            return response()->json([
                "updated" => "-2",
                "message" => "Vous ne pouvez pas utiliser cette adresse e-mail."
            ]);

        if ($userLogin && $userLogin->id != $user->id)
            return response()->json([
                "updated" => "-3",
                "message" => "Vous ne pouvez pas utiliser cet idenfiant."
            ]);
        
        $user->name = $r->login;
        $user->email = $r->email;
        $user->password = Hash::make($r->password);
        $user->save();

        return response()->json([
            "updated" => "1"
        ], 200);
    }
}