<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Database\Seeders\JADBudgetTestSeeder;
use App\Models\User;
use App\Models\Transaction;

uses(RefreshDatabase::class);

/**
 * Factory create 5 expenses, 5 invoices, 5 incomes, 5 model invoices + 1 User (jalal / 12345678 / zachari_86@hotmail.fr)
 */

describe('APITests > Login feature', function(){
    it('can give correct response given the credentials', function($login, $password, $loggedResponse){
        $this->seed(JADBudgetTestSeeder::class);
    
        $response = $this->get('/api/login?login='.$login.'&password='.$password);
        
        $response->assertJson([
            'logged' => $loggedResponse
        ]);
    })->with([
        ['jalal', '12345678', '1'],
        ['jalal', '1234', '0'],
        ['jalal', null, '0'],
        [null, '12345678', '0'],
        [null, '12345', '0'],
        [null, null, '0'],
        ['jalal', '', '0'],
        ['', '12345678', '0'],
        ['', '12345', '0']
    ]);
});

describe('APITests > Datas manipulation', function(){

    it('retrieves 20 lines of datas', function($login, $password, $type){
        $this->seed(JADBudgetTestSeeder::class);
        
        $user = $this->get('/api/login?login='.$login.'&password='.$password);
        $token = $user->json('token');
    
        $response = $this->get('api/retrieveDatas?login='.$login.'&password='.$password.'&type='.$type.'&token='.$token);
        $sizeOfDatas = array_filter(explode('<n>', $response->json('datas')), function($w){
            return strlen($w) > 5;
        });
    
        $response->assertJson([
            "logged" => "1"
        ]);
    
        expect($sizeOfDatas)->toHaveCount(JADBudgetTestSeeder::getTotalRows());
    })->with([
        ['jalal', '12345678', 'ALL_DATAS']
    ]);

    it('retrieves only one type of data', function($login, $password, $type, $count){
        $this->seed(JADBudgetTestSeeder::class);
        
        $userToken = $this->get('/api/login?login='.$login.'&password='.$password);
        $token = $userToken->json('token');
    
        $transactionResponse = $this->get('api/retrieveDatas?login='.$login.'&password='.$password.'&type='.$type.'&token='.$token);
        $transactionDatas = array_filter(explode('<n>', $transactionResponse->json('datas')), function($w){
            return strlen($w) > 5;
        });

        expect(count($transactionDatas))->toBe($count);
        foreach($transactionDatas as $transaction){
            $parts = explode('<l>', $transaction);
            expect($parts[6])->toBe($type);
        }
    })->with([
        ['jalal', '12345678', 'INVOICE', 5],
        ['jalal', '12345678', 'INCOME', 5],
        ['jalal', '12345678', 'EXPENSE', 5],
        ['jalal', '12345678', 'MODELINVOICE', 5]
    ]);
    
    it('does not retrieve datas if bad or no token', function($login, $password, $type, $token){
        $this->seed(JADBudgetTestSeeder::class);
        
        $response = $this->get('api/retrieveDatas?login='.$login.'&password='.$password.'&type='.$type.'&token='.$token);
        $sizeOfDatas = array_filter(explode('<n>', $response->json('datas')), function($w){
            return strlen($w) > 5;
        });
    
        $response->assertJson([
            "logged" => "0"
        ]);
    })->with([
        ['jalal', '12345678', 'ALL_DATAS', 'BAD_TOKEN'],
        ['jalal', '12345678', 'ALL_DATAS', ''],
        ['jalal', '12345678', 'ALL_DATAS', null],
    ]);

    it('delete a transaction', function($login, $password, $type){
        $this->seed(JADBudgetTestSeeder::class);
        $user = User::where('name', $login)->first();

        $transactionToDelete = Transaction::factory()->create([
            'user_id' => $user->id,
            'label' => 'Transaction to delete',
            'type' => 'EXPENSE'
        ]);
        
        $loginResponse = $this->get("/api/login?login=$login&password=$password");
        $token = $loginResponse->json('token');

        $loginResponse->assertOk()->assertJson([
            "logged" => "1"
        ]);
        
        $deleteResponse = $this->get("api/deleteTransaction?login=$login&password=$password&transaction_id=$transactionToDelete->id&token=$token");
        
        $deleteResponse->assertOk()->assertJson([
            "logged" => "1"
        ]);

        $this->assertDatabaseMissing('transactions', [
            'id' => $transactionToDelete->id,
            'user_id' => $user->id
        ]);

        $remainingTransactionsCount = Transaction::where('user_id', $user->id)->count();
        expect($remainingTransactionsCount)->toBe(JADBudgetTestSeeder::getTotalRows());

    })->with([
        ['jalal', '12345678', 'ALL_DATAS']
    ]);

    it('creates a transaction', function($login, $password, $label, $amount, $type){
        $this->seed(JADBudgetTestSeeder::class);

        $response = $this->get("/api/login?login=$login&password=$password");
        $token = $response->json('token');

        $response = $this->get("/api/addTransaction?login=$login&password=$password&token=$token&label=$label&amount=$amount&type=$type");
        expect($response->json("logged"))->toBe("1");

        expect(count(Transaction::where('user_id', User::where('name', $login)->first()->id)->get()))->toBe(21);
    })->with([
        ['jalal', '12345678', 'test ajout', '15', 'INVOICE']
    ]);

    it('can export new data, replacing existing transactions by type', function(){
        $this->seed(JADBudgetTestSeeder::class); // Seeds 100 of each type
        $user = User::where('name', 'jalal')->first();

        expect(Transaction::where('user_id', $user->id)->count())->toBe(JADBudgetTestSeeder::getTotalRows()); // 100 of each type in seeder

        $loginResponse = $this->get('/api/login?login=jalal&password=12345678');
        $token = $loginResponse->json('token');
        
        $newExpenseId1 = rand(1000, 9999);
        $newExpenseId2 = rand(1000, 9999);
        $newIncomeId1 = rand(1000, 9999);
        $newInvoiceId1 = rand(1000, 9999);
        $newModelInvoiceId1 = rand(1000, 9999);


        $datasString = 
            $newExpenseId1 . "<l>New Expense 1<l>150.50<l>daily<l>acc1<l>1<l>EXPENSE<l>10<n>" .
            $newExpenseId2 . "<l>New Expense 2<l>200.00<l><l>acc2<l>0<l>EXPENSE<l>11<n>" . 
            $newIncomeId1 . "<l>New Income<l>500.25<l>monthly<l>acc3<l>1<l>INCOME<l>12<n>" .
            $newInvoiceId1 . "<l>New Invoice<l>75.00<l><l>acc4<l>0<l>INVOICE<l>13<n>" .
            $newModelInvoiceId1 . "<l>New Model Invoice<l>120.00<l>yearly<l>acc5<l>1<l>MODELINVOICE<l>14<n>";

        $exportResponse = $this->get("api/exportDatas?login=jalal&password=12345678&datas=$datasString&token=$token");

        $exportResponse->assertJson([
            "logged" => "1",
            "datas" => $datasString
        ]);

        expect(Transaction::where('user_id', $user->id)->count())->toBe(5);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'transaction_app_id' => $newExpenseId1,
            'type' => 'EXPENSE',
            'label' => 'New Expense 1',
            'amount' => "150.50",
            'paid' => "1",
            'category_id' => "10",
        ]);
        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'transaction_app_id' => $newExpenseId2,
            'type' => 'EXPENSE',
            'label' => 'New Expense 2',
            'amount' => "200.00",
            'period' => "",
            'paid' => "0",
            'category_id' => "11",
        ]);
        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'transaction_app_id' => $newIncomeId1,
            'type' => 'INCOME',
            'label' => 'New Income',
            'amount' => "500.25",
            'paid' => "1",
            'category_id' => "12",
        ]);
        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'transaction_app_id' => $newInvoiceId1,
            'type' => 'INVOICE',
            'label' => 'New Invoice',
            'amount' => "75.00",
            'paid' => "0",
            'category_id' => "13",
        ]);
        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'transaction_app_id' => $newModelInvoiceId1,
            'type' => 'MODELINVOICE',
            'label' => 'New Model Invoice',
            'amount' => "120.00",
            'paid' => "1",
            'category_id' => "14",
        ]);
    });

    it('does not export data if bad or no token', function($login, $password, $datas, $token){
        $this->seed(JADBudgetTestSeeder::class); 

        $response = $this->get("api/exportDatas?login=$login&password=$password&datas=$datas&token=$token");

        $response->assertStatus(403);
        $response->assertJson([
            "logged" => "0"
        ]);

        $user = User::where('name', 'jalal')->first();
        expect(Transaction::where('user_id', $user->id)->count())->toBe(JADBudgetTestSeeder::getTotalRows());
    })->with([
        ['jalal', '12345678', 'dummy<l>data<n>', 'BAD_TOKEN'],
        ['jalal', '12345678', 'dummy<l>data<n>', ''],
        ['jalal', '12345678', 'dummy<l>data<n>', null]
    ]);
});
