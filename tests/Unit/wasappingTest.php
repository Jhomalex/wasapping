<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\User;

class wasappingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = User::find(1);
        $this->be($user);
        $request = new Request();
        $request->replace([
        ]);
        
        dd($request);

        $this->assertTrue(true);
    }
}
