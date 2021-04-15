<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Style;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StyleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Style::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name;

        return [
            'slug' => Str::slug($name),
            'name' => $name,
            'css' => '.style{background:#f00; color:var(--color-black);}',
            'js' => '$(() => console.log(\'algo\')',
            'show' => '-1',
            'level' => '-1',
            'user' => '-1',
            'user_id' => User::first()
        ];
    }
}
