<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Str;

use App\Models\Transaction;
use App\Models\User;
use Exception;

class APIController extends Controller
{
    protected function convertTransactionLineToDatas(Transaction $t): String{
        return ($t->transaction_app_id)."<l>".
                ($t->label)."<l>".
                ($t->amount)."<l>".
                (strlen($t->period) == 0 ? "" : $t->period)."<l>".
                (strlen($t->account_id) == 0 ? "" : $t->account_id)."<l>".
                (strlen($t->paid) == 0 ? "" : $t->paid)."<l>".
                ($t->type)."<l>".
                ($t->id)."<l>".
                ($t->category_id)."<n>";
    }

    function login(Request $r) {
        
        $user = $r->attributes->get('user');
        if (!$user){
            return response()->json([
                "logged" => "0",
                "message" => "APIController > Bad credentials"
            ], 401);
        }

        $user->remember_token = Str::random(60);
        $user->save();

        return response()->json([
            "logged" => "1",
            "token" => $user->remember_token
        ]);

    }
    
    /**
     * When displaying the list of transation in application, we check if the token is valid
     */
    function checkToken(Request $r){
        $user = User::where('name', $r->login)->first();
        if ($r->token == $user->remember_token)
            return response()->json([
                "logged" => "1"
            ]);
            
        return response()->json([
            "logged" => "0",
            "message" => "Bad token, or token expired"
        ]);
    }

    function exportDatas(Request $r){
        $user = $r->attributes->get('user');
        $datas = $r->datas;
        $token = $r->token;

        if (!$user || $token == null || $token != $user->remember_token)
            return response()->json([
                "logged" => "0",
                "message" => "Bad token"
            ], 403);
        
        try {
            if (str_contains($datas, "<n>") && str_contains($datas, "<l>")){
                $user_id = $user->id;
                
                if (str_contains($datas, "<l>EXPENSE")){
                    Transaction::where("user_id", $user_id)->where("type", "EXPENSE")->delete();
                }
                if (str_contains($datas, "<l>INVOICE")){
                    Transaction::where("user_id", $user_id)->where("type", "INVOICE")->delete();
                }
                if (str_contains($datas, "<l>INCOME")){
                    Transaction::where("user_id", $user_id)->where("type", "INCOME")->delete();
                }
                if (str_contains($datas, "<l>MODELINVOICE")){
                    Transaction::where("user_id", $user_id)->where("type", "MODELINVOICE")->delete();
                }

                $modelInvoiceRows = explode("<n>", $datas);
                for ($row = 0; $row < count($modelInvoiceRows); $row++){
                    $cols = explode("<l>", $modelInvoiceRows[$row]);
                    
                    if (count($cols) >= 6){
                        $modelInvoice = Transaction::where("user_id", $user_id)->where("transaction_app_id", $cols[0])->where('type', $cols[6])->first();
                    
                        if (!$modelInvoice){
                            Transaction::create([
                                "transaction_app_id" => $cols[0],
                                "user_id" => $user_id,
                                "label" => $cols[1],
                                "amount" => $cols[2],
                                "period" => $cols[3],
                                "account_id" => $cols[4],
                                "paid" => $cols[5],
                                "type" => $cols[6],
                                "category_id" => $cols[7]
                            ]);
                            
                        } else {
                            $modelInvoice->label = $cols[1];
                            $modelInvoice->amount = $cols[2];
                            $modelInvoice->period = $cols[3];
                            $modelInvoice->account_id = $cols[4];
                            $modelInvoice->paid = $cols[5];
                            $modelInvoice->type = $cols[6];
                            $modelInvoice->save();
                        }
                    }
                }
            }
            
            return response()->json([
                "logged" => "1",
                "datas" => $datas
            ], 200);
            
        } catch(Exception $e){
            return response()->json([
            "logged" => "0",
            "message" => $e->getMessage()
            ], 403);
        }
    }

    function retrieveDatas(Request $r){
        $user = $r->attributes->get('user');
        $token = $r->token;
        $type = $r->type;
        
        if ($token == null || $token != $user->remember_token)
            return response()->json([
                "logged" => "0",
                "message" => "Bad token"
            ]);

        $datas = "";
        
        if (str_contains($type, "ALL_DATAS")){
            foreach(Transaction::where('user_id', $user->id)->get() as $t)
                $datas .= $this->convertTransactionLineToDatas($t);
        } else {
            foreach(Transaction::where('user_id', $user->id)->where('type', $type)->get() as $t)
                $datas .= $this->convertTransactionLineToDatas($t);
        }
            
        return response()->json([
            "logged" => "1",
            "type" => $type,
            "user_id" => $user->id,
            "datas" => $datas
        ], 200);
        
    }

    function deleteTransaction(Request $r){
        $user = $r->attributes->get('user');
        $token = $r->token;
        $transactionId = $r->transaction_id;
        
        if (!$user || $token == null || $token != $user->remember_token){
            return response()->json([
                "logged" => "0",
                "message" => "Bad token"
            ], 403);
        }

        Transaction::where('id', $transactionId)->delete();
        
        return response()->json([
            "logged" => "1",
            "datas" => "delete transaction_ID : ".$transactionId
        ], 200);
        
    }

    function addTransaction(Request $r){
        $user = $r->attributes->get('user');
        $token = $r->token;
        $label = $r->label;
        $amount = $r->amount;
        $type = $r->type;

        if (!$user || $token == null || $token != $user->remember_token)
            return response()->json([
                "logged" => "0",
                "message" => "Bad token"
            ], 403);
        
        Transaction::create([
            "transaction_app_id" => 0,
            "user_id" => $user->id,
            "label" => $label,
            "amount" => $amount,
            "period" => "",
            "account_id" => "",
            "paid" => "0",
            "type" => $type    
        ]);
        
        return response()->json([
            "logged" => "1"
        ], 200);

    }
}
 