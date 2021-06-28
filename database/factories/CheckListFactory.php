<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\CheckList;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CheckList::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => Str::random(20),
            'user_id' => User::find(1)->id
        ];
    }
}
