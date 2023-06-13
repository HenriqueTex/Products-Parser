<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {

        return [
            'code' => (string)$this->faker->unique()->randomNumber(1000),
            'status' => ProductStatus::Published,
            'imported_t' => $this->faker->dateTimeThisYear(),
            'url' => $this->faker->url,
            'creator' => $this->faker->userName,
            'created_t' => $this->faker->unixTime,
            'last_modified_t' => $this->faker->unixTime,
            'product_name' => $this->faker->words(3, true),
            'quantity' => $this->faker->numberBetween(0, 100),
            'brands' => $this->faker->company,
            'categories' => $this->faker->words(5, true),
            'labels' => $this->faker->words(3, true),
            'cities' => $this->faker->city,
            'purchase_places' => $this->faker->city . ',' . $this->faker->country,
            'stores' => $this->faker->company,
            'ingredients_text' => $this->faker->sentence,
            'traces' => $this->faker->sentence,
            'serving_size' => $this->faker->word,
            'serving_quantity' => $this->faker->randomFloat(1, 0.1, 100),
            'nutriscore_score' => $this->faker->numberBetween(0, 100),
            'nutriscore_grade' => $this->faker->randomElement(['a', 'b', 'c', 'd', 'e']),
            'main_category' => $this->faker->word,
            'image_url' => $this->faker->imageUrl(),
        ];
    }
}
