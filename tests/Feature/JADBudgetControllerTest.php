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

    it("doesn't log in with bad credentials", function($login, $password, $status){
        $this->seed(JADBudgetTestSeeder::class);

        $response = $this->post('/JADBudget/login', [
            "login" => $login,
            "password" => $password
        ]);

        $response->assertStatus($status);
        
        $this->assertGuest();
    })->with([
        ['jalal', 'wrong_password', 401],
        ['wrong_user', '12345678', 302],
        ['', '12345678', 302],
    ]);

    it('sign in', function($name, $email, $password, $statusResponse){
        $this->seed(JADBudgetTestSeeder::class);

        $response = $this->post('/JADBudgetV2/signinV2', [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        $response->assertStatus($statusResponse);

    })->with([
        ['jalal', 'zachari_86@hotmail.fr', '12345678', 302],
        ['jalal', 'zachari_86@hotmail.com', '12345678', 302],
        ['j', 'zachari_86@hotmail.com', '12345678', 302],
        ['jalal2', 'zachari_87@hotmail.com', '12345678', 302],
        [null, 'zachari_86@hotmail.com', '1234', 302],
        [null, null, null, 302],
    ]);

    it ('displays dashboard if connected', function(){
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/JADBudgetV2/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewIs('JADBudgetV2.dashboard');
    });

    it ('redirect to index if not connected', function(){
        $response = $this->get('/JADBudgetV2/dashboard');
        $response->assertRedirect('/JADBudgetV2');
    });

    it('retrieves user informations', function(){
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post('/JADBudgetV2/getUserInfos');
        $response->assertStatus(200);
        $response->assertJson([
            "userName" => $user->name,
            "userEmail" => $user->email
        ]);
    });

    it("does not retrieve info if not connected", function(){
        $response = $this->post('/JADBudgetV2/getUserInfos');
        $response->assertRedirect('/JADBudgetV2');
    });

    it("update user info if connected", function(){
        $user = User::create([
            'name' => 'test',
            'email' => 'test@mail.com',
            'password' => Hash::make('123456789')
        ]);

        $response = $this->actingAs($user)->post('/JADBudgetV2/updateUserInfos', [
            'name' => 'newTest',
            'email' => 'newEmail@gmail.com',
            'password' => '123456789'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'newTest',
            'email' => 'newEmail@gmail.com'
        ]);
    });

    it("update password if connected user", function(){
        $user = User::create([
            'name' => 'test',
            'email' => 'test@mail.com',
            'password' => Hash::make('123456789')
        ]);

        $response = $this->actingAs($user)->post('/JADBudgetV2/updatePassword', [
            'oldPassword' => '123456789',
            'newPassword' => '123456788',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);

        expect(Hash::check('123456788', $user->password))->toBe(true);
    });

    it("does not update user password when not connected", function(){
        $response = $this->post('/JADBudgetV2/updatePassword', [
            'oldPassword' => '123456789',
            'newPassword' => '123456788',
        ]);

        $response->assertStatus(302);
    });

    it("update user info if not connected", function(){
        $user = User::create([
            'name' => 'test',
            'email' => 'test@mail.com',
            'password' => Hash::make('123456789')
        ]);

        $response = $this->post('/JADBudgetV2/updateUserInfos', [
            'name' => 'newTest',
            'email' => 'newEmail@gmail.com',
            'password' => '123456789'
        ]);

        $response->assertStatus(302);
    });

    it("correctly log us out", function(){
        $response = $this->get('/JADBudgetV2/logout');
        $response->assertStatus(302);
        $response->assertRedirect('/JADBudgetV2');
    });
})->only();

describe("JADBudgetController > Datas manipulation", function(){
    it("correctly fetches data when logged in", function($type, $numberOfElements){
        $this->seed(JADBudgetTestSeeder::class);
        $user = User::where('name', 'jalal')->first();
        
        $response = $this->actingAs($user)->post('/JADBudgetV2/getTransactionsByType', [
            'type' => $type
        ]);
        $response->assertStatus(200);
        $transactions = $response->json('transactionList');
        expect(count($transactions))->toBe($numberOfElements);
    })->with([
        ["INVOICE", 5],
        ["EXPENSE", 5],
        ["INCOME", 5],
        ["MODELINVOICE", 5],
        ["DUMMY_TYPE", 0]
    ]);

    it("fetches no data when not logged in", function(){
        $response = $this->post('/JADBudgetV2/getTransactionsByType');
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
            "transaction_label" => $transaction_todelete->label
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