<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $availableHour = $this->faker->numberBetween(10,18);    //　１０時〜１８時　
        $minutes = [0,30];                                      // 0分か３０分
        $mKey = array_rand($minutes);                           // ランダムにキーを取得
        $addHour = $this->faker->numberBetween(1,3);            // イベント時間１時間〜３時間

        // $dummyDate = $this->faker->dateTimeThisMonth;
        $dummyDate = $this->faker->dateTimeBetween('-1 months','+1 months');
        $startDate = $dummyDate->setTime($availableHour,$minutes[$mKey]);
        $clone = clone $startDate;
        $endDate = $clone->modify('+'.$addHour.'hour');

        // dd($startDate,$endDate);
         
        return [
            //
            'name' => $this->faker->name,
            'information' => $this->faker->realText,
            'max_people' => $this->faker->numberBetween(1,20),
            // 'start_date' => $dummyDate->format('Y-m-d H:i:s'),
            // 'end_date' => $dummyDate->modify('+1hour')->format('Y-m-d H:i:s'),
            'start_date' => $startDate->format('Y-m-d H:i:s'),
            'end_date' => $endDate->format('Y-m-d H:i:s'),
            'is_visible' => $this->faker->boolean,
        ];
    }
}
