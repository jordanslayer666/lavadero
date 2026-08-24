<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // ===== USUARIOS =====

        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin Dueño',
            'email' => 'admin@lavadero.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $host = \App\Models\User::factory()->create([
            'name' => 'Anfitrión Recepción',
            'email' => 'anfitrion@lavadero.com',
            'password' => bcrypt('password'),
            'role' => 'host',
        ]);

        $juan = \App\Models\User::factory()->create([
            'name' => 'Juan Lavador',
            'email' => 'juan@lavadero.com',
            'password' => bcrypt('password'),
            'role' => 'washer',
            'commission_rate' => 30.00
        ]);

        $pedro = \App\Models\User::factory()->create([
            'name' => 'Pedro Lavador',
            'email' => 'pedro@lavadero.com',
            'password' => bcrypt('password'),
            'role' => 'washer',
            'commission_rate' => 30.00
        ]);

        $maria = \App\Models\User::factory()->create([
            'name' => 'María Lavadora',
            'email' => 'maria@lavadero.com',
            'password' => bcrypt('password'),
            'role' => 'washer',
            'commission_rate' => 25.00
        ]);

        // ===== LAVADOS DE PRUEBA =====
        $washers = [$juan, $pedro, $maria];
        $vehicleTypes = ['Carro', 'Camioneta', 'Camión', 'Moto'];
        $colors = ['Rojo', 'Azul', 'Negro', 'Blanco', 'Gris', 'Plateado', 'Verde'];
        $paymentMethods = ['Efectivo', 'Tarjeta', 'Transferencia', 'Yape/Plin'];

        // Lavados de meses anteriores (para el gráfico)
        for ($month = 5; $month >= 1; $month--) {
            $count = rand(2, 6);
            for ($i = 0; $i < $count; $i++) {
                $washer = $washers[array_rand($washers)];
                $price = rand(15, 80);
                $commission = ($price * $washer->commission_rate) / 100;

                \App\Models\Wash::create([
                    'host_id' => $host->id,
                    'washer_id' => $washer->id,
                    'vehicle_type' => $vehicleTypes[array_rand($vehicleTypes)],
                    'plate_number' => strtoupper(chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90))).'-'.rand(100,999),
                    'color' => $colors[array_rand($colors)],
                    'details' => null,
                    'price' => $price,
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'washer_payment' => $commission,
                    'status' => 'completed',
                    'created_at' => Carbon::now()->subMonths($month)->addDays(rand(0, 25)),
                    'updated_at' => Carbon::now()->subMonths($month)->addDays(rand(0, 25)),
                ]);
            }
        }

        // Lavados de hoy (algunos en progreso, algunos completados)
        $todayWashes = [
            ['type' => 'Carro', 'plate' => 'ABC-123', 'color' => 'Rojo', 'price' => 25, 'status' => 'completed'],
            ['type' => 'Camioneta', 'plate' => 'XYZ-789', 'color' => 'Negro', 'price' => 45, 'status' => 'completed'],
            ['type' => 'Moto', 'plate' => 'MOT-456', 'color' => 'Azul', 'price' => 15, 'status' => 'in_progress'],
            ['type' => 'Carro', 'plate' => 'DEF-321', 'color' => 'Blanco', 'price' => 30, 'status' => 'in_progress'],
            ['type' => 'Camión', 'plate' => 'CAM-111', 'color' => 'Gris', 'price' => 70, 'status' => 'in_progress'],
        ];

        foreach ($todayWashes as $w) {
            $washer = $washers[array_rand($washers)];
            $commission = ($w['price'] * $washer->commission_rate) / 100;

            \App\Models\Wash::create([
                'host_id' => $host->id,
                'washer_id' => $washer->id,
                'vehicle_type' => $w['type'],
                'plate_number' => $w['plate'],
                'color' => $w['color'],
                'price' => $w['price'],
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'washer_payment' => $commission,
                'status' => $w['status'],
            ]);
        }
    }
}
