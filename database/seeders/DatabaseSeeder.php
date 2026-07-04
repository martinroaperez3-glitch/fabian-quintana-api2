<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Service;
use App\Models\Schedule;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================
        // Tenant
        // ==========================
        $tenant = Tenant::firstOrCreate(
            [
                'slug' => 'fabian-quintana-salon'
            ],
            [
                'name' => 'Fabián Quintana Salón',
                'phone' => '+595981000000',
                'whatsapp' => '595981000000',
                'address' => 'Encarnación',
                'city' => 'Encarnación',
                'country' => 'Paraguay',
                'is_active' => true,
            ]
        );

        // ==========================
        // Usuario Administrador
        // ==========================
        $user = User::firstOrCreate(
            [
                'email' => 'admin@fabian.com'
            ],
            [
                'tenant_id' => $tenant->id,
                'name' => 'Fabián Quintana',
                'password' => bcrypt('123456'),
                'role' => 'owner',
                'is_active' => true,
            ]
        );

        // ==========================
        // Servicios
        // ==========================

        Service::firstOrCreate(
            [
                'tenant_id' => $tenant->id,
                'name' => 'Corte'
            ],
            [
                'description' => '',
                'duration_minutes' => 30,
                'price' => 70000,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        Service::firstOrCreate(
            [
                'tenant_id' => $tenant->id,
                'name' => 'Barba'
            ],
            [
                'description' => '',
                'duration_minutes' => 30,
                'price' => 40000,
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        Service::firstOrCreate(
            [
                'tenant_id' => $tenant->id,
                'name' => 'Combo'
            ],
            [
                'description' => '',
                'duration_minutes' => 60,
                'price' => 100000,
                'is_active' => true,
                'sort_order' => 3,
            ]
        );

        Service::firstOrCreate(
            [
                'tenant_id' => $tenant->id,
                'name' => 'Color'
            ],
            [
                'description' => '',
                'duration_minutes' => 60,
                'price' => 130000,
                'is_active' => true,
                'sort_order' => 4,
            ]
        );

        // ==========================
        // Horarios
        // ==========================

        foreach ([1, 2, 3, 4, 5, 6] as $day) {

            // Mañana
            Schedule::firstOrCreate(
                [
                    'tenant_id' => $tenant->id,
                    'user_id' => $user->id,
                    'day_of_week' => $day,
                    'opens_at' => '09:00:00',
                ],
                [
                    'closes_at' => '12:00:00',
                    'is_active' => true,
                ]
            );

            // Tarde
            Schedule::firstOrCreate(
                [
                    'tenant_id' => $tenant->id,
                    'user_id' => $user->id,
                    'day_of_week' => $day,
                    'opens_at' => '14:30:00',
                ],
                [
                    'closes_at' => '19:30:00',
                    'is_active' => true,
                ]
            );
        }

        echo PHP_EOL;
        echo "======================================" . PHP_EOL;
        echo " Base de datos inicializada" . PHP_EOL;
        echo "======================================" . PHP_EOL;
        echo "Tenant: {$tenant->name}" . PHP_EOL;
        echo "Usuario: admin@fabian.com" . PHP_EOL;
        echo "Contraseña: 123456" . PHP_EOL;
        echo "Servicios: " . Service::count() . PHP_EOL;
        echo "Horarios: " . Schedule::count() . PHP_EOL;
        echo "======================================" . PHP_EOL;
    }
}