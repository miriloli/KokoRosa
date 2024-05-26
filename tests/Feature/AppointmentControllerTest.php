<?php

namespace Tests\Unit;


use App\Models\User;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase as BaseTestCase;


class AppointmentControllerTest extends BaseTestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_available_hours_excluding_weekends()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $selectedDate = '2024-05-27';
        $request = new Request(['date' => $selectedDate]);

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $controller = new \App\Http\Controllers\AppointmentController();
        $response = $controller->availableHours($request);

        $availableHours = $response->getData()['finallyAvailableHours'];
        $this->assertNotContains('14:00:00', $availableHours);
        $this->assertNotContains('14:30:00', $availableHours);
        $this->assertNotContains('15:00:00', $availableHours);
        $this->assertNotContains('15:30:00', $availableHours);
    }

    /** @test */
    public function it_returns_error_for_weekend_dates()
    {
        $selectedDate = '2024-05-25';
        $request = new Request(['date' => $selectedDate]);

        $controller = new \App\Http\Controllers\AppointmentController();
        $response = $controller->availableHours($request);

        // $response->assertViewIs('daySelection');
        // $response->assertViewHas('error', 'No se pueden pedir citas los fines de semana.');
    }

    /** @test */
    public function it_creates_an_appointment()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $service = Service::factory()->create(['name' => 'Consultation']);
        $employee = Employee::factory()->create();

        $request = new Request([
            'service' => 'Consultation',
            'date' => '2024-05-27 10:00:00'
        ]);

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $controller = new \App\Http\Controllers\AppointmentController();
        $response = $controller->createAppointment($request);

        $this->assertDatabaseHas('appointments', [
            'customer_id' => $user->id,
            'service_id' => $service->id,
            'employee_id' => $employee->id,
            'date' => '2024-05-27 10:00:00',
            'cancelled' => false
        ]);

        // $response->assertViewIs('yourAppointments');
        // $response->assertViewHas('appointments');
    }
}

