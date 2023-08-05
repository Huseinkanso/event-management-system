<?php

namespace Database\Factories;

use App\Models\Category;
use Carbon\Carbon;
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
    public function definition(): array
    {

        return [
            'name'=>fake()->name(),
            'description'=>fake()->text(),
            'address'=>fake()->address(),
            'image'=>fake()->imageUrl(),
            'ticket_price'=>fake()->numberBetween(200,800),
            'ticket_remaining'=>fake()->numberBetween(1,200),
            'categorie_name'=> Category::inRandomOrder()->first()->categorie_name,
            'date'=>Carbon::createFromTimestamp(mt_rand(Carbon::now()->timestamp,Carbon::today()->addMonths()->timestamp)),
            'published_at'=>Carbon::createFromTimestamp(mt_rand(Carbon::now()->timestamp,Carbon::today()->addWeek()->timestamp))

        ];
    }
}
