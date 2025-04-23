<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aircraft;

class AircraftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aircrafts = [
            [
                'title' => 'Boeing 747',
                'description' => 'A large, long-range wide-body airliner.',
                'image' => 'boeing_747.jpg',
                'type' => 'commercial',
                'aircraft_type' => 'airliner',
            ],
            [
                'title' => 'Cessna 172',
                'description' => 'A single-engine, high-wing aircraft.',
                'image' => 'cessna_172.jpg',
                'type' => 'civilian',
                'aircraft_type' => 'propeller',
            ],
            [
                'title' => 'F-16 Fighting Falcon',
                'description' => 'A multirole jet fighter aircraft.',
                'image' => 'f16_fighting_falcon.jpg',
                'type' => 'military',
                'aircraft_type' => 'fighter',
            ],
            [
                'title' => 'Airbus A380',
                'description' => 'The world\'s largest passenger airliner.',
                'image' => 'airbus_a380.jpg',
                'type' => 'commercial',
                'aircraft_type' => 'airliner',
            ],
            [
                'title' => 'Piper PA-28',
                'description' => 'A family of light aircraft.',
                'image' => 'piper_pa28.jpg',
                'type' => 'civilian',
                'aircraft_type' => 'propeller',
            ],
            [
                'title' => 'Boeing 777',
                'description' => 'A long-range wide-body twin-engine jet.',
                'image' => 'boeing_777.jpg',
                'type' => 'commercial',
                'aircraft_type' => 'airliner',
            ],
            [
                'title' => 'Lockheed Martin F-35 Lightning II',
                'description' => 'A family of stealth multirole fighters.',
                'image' => 'f35_lightning_ii.jpg',
                'type' => 'military',
                'aircraft_type' => 'fighter',
            ],
            [
                'title' => 'Cessna Citation X',
                'description' => 'A twin-engine business jet.',
                'image' => 'cessna_citation_x.jpg',
                'type' => 'civilian',
                'aircraft_type' => 'airliner',
            ],
            [
                'title' => 'Airbus A320',
                'description' => 'A short- to medium-range commercial jet airliner.',
                'image' => 'airbus_a320.jpg',
                'type' => 'commercial',
                'aircraft_type' => 'airliner',
            ],
            [
                'title' => 'Boeing CH-47 Chinook',
                'description' => 'A tandem rotor heavy-lift helicopter.',
                'image' => 'boeing_ch47_chinook.jpg',
                'type' => 'military',
                'aircraft_type' => 'helicopter',
            ]
            ];

        foreach ($aircrafts as $aircraft) {
            Aircraft::create($aircraft);
        }
    }
}
