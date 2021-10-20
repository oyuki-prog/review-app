<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $width = 500;
        $height = random_int(250, 600);

        $file = $this->faker->image(null, $width, $height);
        $path = Storage::putFile('reviews', $file);
        File::delete($file);
        return [
            'review_id' => Review::inRandomOrder()->first(),
            'name' => basename($path),
        ];
    }
}
