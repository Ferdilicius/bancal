<?php
namespace Database\Factories;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;

    public function definition(): array
    {
        $types = ['card', 'paypal', 'bizum', 'bank_transfer'];
        $type = $this->faker->randomElement($types);

        return [
            'user_id' => User::factory(),
            'type' => $type,
            'provider' => match($type) {
                'card' => $this->faker->randomElement(['Visa', 'MasterCard']),
                'paypal' => 'PayPal',
                'bizum' => 'Bizum',
                'bank_transfer' => $this->faker->randomElement(['BBVA', 'CaixaBank', 'Santander']),
            },
            'account_name' => $this->faker->name(),
            'account_number' => match($type) {
                'card' => '**** **** **** ' . $this->faker->randomNumber(4, true),
                'paypal' => $this->faker->safeEmail(),
                'bizum' => $this->faker->phoneNumber(),
                'bank_transfer' => 'ES' . $this->faker->numberBetween(1000000000000000000000, 9999999999999999999999),
            },
            'expiration' => $type === 'card' ? $this->faker->creditCardExpirationDate()->format('m/y') : null,
            'is_default' => false,
        ];
    }
}
