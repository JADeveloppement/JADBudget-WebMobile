<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Database\Seeders\JADBudgetTestSeeder;
use App\Models\User;
use App\Models\Transaction;

use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

describe('JADBudgetController > Login features', function(){
    it('login with good credentials', function () {
        $this->seed(JADBudgetTestSeeder::class);
        $user = User::where('name', 'jalal')->first();

        $response = $this->post('/JADBudget/login', [
            "login" => $user->name,
            "password" => '12345678'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            "logged" => "1"
        ]);
        
        $this->assertAuthenticatedAs($user);
    });


    /**
     * SHOULD FAIL with empty credentials
     */
    it("doesn't log in with bad credentials", function($login, $password){
        $this->seed(JADBudgetTestSeeder::class);

        $response = $this->post('/JADBudget/login', [
            "login" => $login,
            "password" => $password
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            "logged" => "0",
            "message" => "Mauvais identifiants"
        ]);
        
        $this->assertGuest();
    })->with([
        ['jalal', 'wrong_password'],
        ['wrong_user', '12345678'],
        ['', '12345678'],
    ]);

    /** SHOULD FAIL WITH LOGIN HAVING NUMBER
     * SHOULD FAIL WHEN EMPTY OR NULL FIELD
     */
    it('sign in', function($name, $email, $password, $statusResponse){
        $this->seed(JADBudgetTestSeeder::class);

        $response = $this->post('/JADBudget/signin', [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        $response->assertStatus($statusResponse);

    })->with([
        ['jalal', 'zachari_86@hotmail.fr', '12345678', 422],
        ['jalal', 'zachari_86@hotmail.com', '12345678', 302],
        ['j', 'zachari_86@hotmail.com', '12345678', 302],
        ['jalal2', 'zachari_87@hotmail.com', '12345678', 422],
        [null, 'zachari_86@hotmail.com', '1234', 302],
        [null, null, null, 302],
    ]);

    /**
     * OBSOLETE BECAUSE OF UPDATE
     */
    // it ('displays dashboard if connected', function(){
    //     $user = User::factory()->create();

    //     $response = $this->actingAs($user)->get('/JADBudget/dashboard');
        
    //     $response->assertStatus(200);
    //     $response->assertViewIs('JADBudget.dashboard');
    // });

    /**
     * OBSOLETE
     */
    // it ('displays profile if connected', function(){
    //     $user = User::factory()->create();
        
    //     $response = $this->actingAs($user)->get('/JADBudget/profile');
    //     $response->assertStatus(200);
    //     $response->assertViewIs('JADBudget.profile');
    // });

    it ('redirect to index if not connected', function(){
        $response = $this->get('/JADBudget/dashboard');
        $response->assertRedirect('/JADBudgetV2');

        $response = $this->get('/JADBudget/profile');
        $response->assertRedirect('/JADBudgetV2');
    });

    it('retrieves user informations', function(){
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post('/JADBudget/getUserInfos');
        $response->assertStatus(200);
        $response->assertJson([
            "userName" => $user->name,
            "userEmail" => $user->email
        ]);
    });

    it("does not retrieve info if not connected", function(){
        $response = $this->post('/JADBudget/getUserInfos');
        $response->assertRedirect('/JADBudgetV2');
    });

    it("correctly log us out", function(){
        $response = $this->get('/JADBudget/disconnect');
        $response->assertStatus(302);
        $response->assertRedirect('/JADBudgetV2');
    });
});

describe("JADBudgetController > Datas manipulation", function(){
    it("correctly fetches data when logged in", function(){
        $this->seed(JADBudgetTestSeeder::class);
        $user = User::where('name', 'jalal')->first();
        
        $response = $this->actingAs($user)->post('/JADBudget/getTransactions');
        $response->assertStatus(200);
        $transactions = $response->json('transactionList');
        expect(count($transactions))->toBe(20);
    });

    it("fetches no data when not logged in", function(){
        $response = $this->post('/JADBudget/getTransactions');
        $response->assertRedirect("/JADBudgetV2");
    });

    it("create a transaction", function($label, $amount, $type, $responseStatus){
        $this->seed(JADBudgetTestSeeder::class);
        $user = User::where('name', 'jalal')->first();
        
        $response = $this->actingAs($user)->post('/JADBudget/addTransaction', [
            "label" => $label,
            "amount" => $amount,
            "type" => $type
        ]);

        $response->assertStatus($responseStatus);

    })->with([
        ['test', '20', 'EXPENSE', 200],
        ['', '20', 'EXPENSE', 302],
        ['test', '', 'EXPENSE', 302],
        ['test', '20', '', 302],
        ['', '', '', 302],
        [null, '20', 'INVOICE', 302],
        ['test', null, 'INVOICE', 302],
        ['test', '20', null, 302],
        [null, null, null, 302]
    ]);

    it("does not create transaction if not logged in", function(){
        $response = $this->post('/JADBudget/addTransaction', [
            "label" => "dummy",
            "amount" => "10",
            "type" => "dummy"
        ]);

        $response->assertRedirect('/JADBudgetV2');
    });

    it("delete a transaction if logged in", function(){
        $this->seed(JADBudgetTestSeeder::class);
        $user = User::where('name', 'jalal')->first();

        $transactions = Transaction::where('user_id', $user->id)->get();
        expect(count($transactions))->toBe(20);

        $transaction_todelete = $transactions[0];
        $response = $this->actingAs($user)->post('/JADBudget/deleteTransaction', [
            'transaction_id' => $transaction_todelete->id
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            "id" => $transaction_todelete->id,
            "DB label" => $transaction_todelete->label
        ]);

        $newTransactionsList = Transaction::where('user_id', $user->id)->get();
        expect(count($newTransactionsList))->toBe(19);
    });

    it ("does not delete record if not logged in", function(){
        $response = $this->post('/JADBudget/deleteTransaction', [
            'transaction_id' => 'dummyId'
        ]);

        $response->assertRedirect('/JADBudgetV2');
    });
});