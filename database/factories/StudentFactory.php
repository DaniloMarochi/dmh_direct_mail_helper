<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class StudentFactory extends Factory {

    public function definition() {
        return [
            "name" => $this->faker->name,
            "email" => $this->faker->email,
            "frequence" => $this->faker->randomNumber(2) + 1,
            "occurrence" => $this->faker->text,
            "mailed" => 0
        ];
    }
}
