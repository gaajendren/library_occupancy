<?php

namespace Database\Factories;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = $this->faker;

        $roomTypeMap = [
            1 => [12, 13], // Iqra Room
            2 => [11, 14], // Hikmah Room
            4 => [8, 9],   // Eksplorasi Room
        ];

      
        $roomTypeId = $faker->randomElement(
            array_merge(
                array_fill(0, 6, 1)
                // ,[2, 2, 4]         
            )
        );

        $roomId = $faker->randomElement($roomTypeMap[$roomTypeId]);
        $time = null;
        
        if ($roomTypeId === 1) {
            $startHour = $faker->numberBetween(8, 16); // 16 is the latest start for 2-hour slot
            $timeArray = [sprintf('%02d:00', $startHour)];

            // 50% chance to add one more hour slot
            if ($faker->boolean() && $startHour < 16) {
                $timeArray[] = sprintf('%02d:00', $startHour + 1);
            }

            $time =  json_encode(json_encode($timeArray)) ;
        }

        return [
            'studentId' => 23,
            'roomId' => $roomId,
            'roomTypeId' => $roomTypeId,
            'date' => $faker->dateTimeBetween('2025-05-01', '2025-06-30')->format('Y-m-d'),
            'time' => $time,
            'status' => 'pending',
            'studentCount' => $faker->numberBetween(int1: 1, int2: 10),
            'matric_pic' => json_encode(['matric_' . $faker->unique()->numberBetween(1000, 9999)]),
            'ticket_no' => 'TKT' . $faker->unique()->numberBetween(10000, 99999),
        ];
    }
}
