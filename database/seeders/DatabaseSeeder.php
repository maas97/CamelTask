<?php

namespace Database\Seeders;

use App\Models\AddonList;
use App\Models\SubscriptionList;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Subscription lists seeders
        SubscriptionList::create([
            'plan_name'     => 'arcade',
            'billing_cycle' => 'monthly',
            'price'         => 9,
        ]);

        SubscriptionList::create([
            'plan_name'     => 'advanced',
            'billing_cycle' => 'monthly',
            'price'         => 12,
        ]);

        SubscriptionList::create([
            'plan_name'     => 'pro',
            'billing_cycle' => 'monthly',
            'price'         => 15,
        ]);

        SubscriptionList::create([
            'plan_name'     => 'arcade',
            'billing_cycle' => 'yearly',
            'price'         => 90,
        ]);

        SubscriptionList::create([
            'plan_name'     => 'advanced',
            'billing_cycle' => 'yearly',
            'price'         => 120,
        ]);

        SubscriptionList::create([
            'plan_name'     => 'pro',
            'billing_cycle' => 'yearly',
            'price'         => 150,
        ]);

        // Addon lists seeders
        AddonList::create([
            'name'     => 'online_service',
            'billing_cycle' => 'monthly',
            'price'         => 1,
        ]);

        AddonList::create([
            'name'     => 'larger_storage',
            'billing_cycle' => 'monthly',
            'price'         => 2,
        ]);

        AddonList::create([
            'name'     => 'customizable_profile',
            'billing_cycle' => 'monthly',
            'price'         => 2,
        ]);

        AddonList::create([
            'name'     => 'online_service',
            'billing_cycle' => 'yearly',
            'price'         => 10,
        ]);

        AddonList::create([
            'name'     => 'larger_storage',
            'billing_cycle' => 'yearly',
            'price'         => 20,
        ]);

        AddonList::create([
            'name'     => 'customizable_profile',
            'billing_cycle' => 'yearly',
            'price'         => 20,
        ]);
    }
}
