<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mockery;
use App\Services\Implements\SampleService;
use App\Repositories\Interface\SampleRepositoryInterface;

class SampleServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        // モック作成
        $mock = (object) Mockery::mock(SampleRepositoryInterface::class);
        $mock->shouldReceive('getUser')
            ->with(1)
            ->andReturn((object) [
                'id' => 1,
                'name' => '山田太郎',
                'email' => 'yamada@example.com',
                'age' => 24
            ])
            ->getMock();

        // メソッド実行
        $sampleService = new SampleService($mock);
        $userObj = $sampleService->getUser(1);

        // アサーション
        $this->assertObjectHasAttribute('id', $userObj);
        $this->assertObjectHasAttribute('name', $userObj);
        $this->assertObjectHasAttribute('email', $userObj);
        $this->assertObjectHasAttribute('age', $userObj);
    }
}
