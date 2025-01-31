<?php

namespace App\Application;

use App\Factory\AirplaneTravelFactory;
use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class CancelTravelByIDTest extends TestCase
{
    protected $cancelTravelByID;
    protected $travel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cancelTravelByID = new CancelTravelByID(1);
        $this->travel = Mockery::mock('alias:App\Models\Travel');
    }

    public function testCancelTravelNotFound()
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('A viagem não foi encontrada');

        $travelMock = $this->travel;
        $travelMock->shouldReceive('find')->andReturn(null);

        $this->cancelTravelByID->cancel();
    }

    public function testCancelTravelUserNotAuthorized()
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Usuário da viagem não pode alterar o status da própria viagem');

        $travelMock = $this->travel;
        $travelMock->id_user = 1;
        $travelMock->method = 'airplane';
        $travelMock->method = '2025-03-01';
        $travelMock->shouldReceive('find')->with(1)->andReturn($travelMock);

        Auth::shouldReceive('id')->andReturn(1);

        $this->cancelTravelByID->cancel();
    }

    public function testCancelTravelSuccess()
    {
        $travelMock = $this->travel;
        $travelMock->id_user = 2;
        $travelMock->method = 'airplane';
        $travelMock->start_date = '2025-03-01';

        $travelMock->shouldReceive('find')->with(1)->andReturn($travelMock);
        $travelMock->shouldReceive('save')->andReturn($travelMock);

        Auth::shouldReceive('id')->andReturn(1);

        $travelMethodFactoryMock = Mockery::mock(AirplaneTravelFactory::class);
        $travelMethodFactoryMock->shouldReceive('cancel')->andReturn($travelMock);

        $result = $this->cancelTravelByID->cancel();

        $this->assertInstanceOf(Travel::class, $result);
    }
}
