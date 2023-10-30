<?php

namespace Database\Seeders;

use App\Models\Sound;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sounds = [
            [
                'name' => '[EFEITO - EXPLOSÃO] Explosão grande',
                'content' => '/sounds/1_explosion.mp3'
            ],
            [
                'name' => '[EFEITO - FERA] Monstro agressivo',
                'content' => '/sounds/2_agressive_monster.mp3'
            ],
            [
                'name' => '[EFEITO - FERA] Monstro barulho',
                'content' => '/sounds/3_vocation_monster.mp3'
            ],
            [
                'name' => '[EFEITO - FERA] Monstro intimidação',
                'content' => '/sounds/4_intimidation_monster.mp3'
            ],
            [
                'name' => '[EFEITO - FERA] Monstro barulho',
                'content' => '/sounds/5_vocation_monster.mp3'
            ],
            [
                'name' => '[EFEITO - AMBIENTE] Floresta',
                'content' => '/sounds/6_enviroment_sound.mp3'
            ],
            [
                'name' => '[EFEITO - AMBIENTE] Floresta noite',
                'content' => '/sounds/7_florest_night.mp3'
            ],
            [
                'name' => '[EFEITO - AMBIENTE] Rio',
                'content' => '/sounds/8_river.mp3'
            ],
            [
                'name' => '[EFEITO - AMBIENTE] Fogueira',
                'content' => '/sounds/9_fire.mp3'
            ],
            [
                'name' => '[EFEITO - AMBIENTE] Multidão dia',
                'content' => '/sounds/10_people_day.mp3'
            ],
            [
                'name' => '[EFEITO - AMBIENTE] Multidão dia',
                'content' => '/sounds/11_people_night.mp3'
            ],
            [
                'name' => '[EFEITO - OBJETOS] Passos',
                'content' => '/sounds/12_walking.mp3'
            ],
            [
                'name' => '[EFEITO - OBJETOS] Porta',
                'content' => '/sounds/13_door.mp3'
            ],
            [
                'name' => '[EFEITO - BARULHOS] Mastigando carne',
                'content' => '/sounds/14_eating_meat.mp3'
            ],
            [
                'name' => '[EFEITO - ANIMAIS] Moscas',
                'content' => '/sounds/15_flies.mp3'
            ],
            [
                'name' => '[EFEITO - OBJETOS] Porta eco',
                'content' => '/sounds/16_door_eco.mp3'
            ],
            [
                'name' => '[EFEITO - OBJETOS] Batidas na porta',
                'content' => '/sounds/17_door_knock.mp3'
            ],

            [
                'name' => '[TRILHA - ANIMADA] Stealth - Aakash Gandhi',
                'content' => '/sounds/18_music.mp3'
            ],
            [
                'name' => '[TRILHA - BATALHA] Chariots of War - Aakash Gandhi',
                'content' => '/sounds/19_music.mp3'
            ],
            [
                'name' => '[TRILHA - COMTEMPLATIVA] Glass - Anno Domini Beats',
                'content' => '/sounds/20_music.mp3'
            ],
            [
                'name' => '[TRILHA - DESPEDIDA] Poison Apple - Quincas Moreira',
                'content' => '/sounds/21_music.mp3'
            ],
            [
                'name' => '[TRILHA - ESTILO] Black Magic - Nana Kwabena',
                'content' => '/sounds/22_music.mp3'
            ],
            [
                'name' => '[TRILHA - ESTILO] Culture - Anno Domini Beats',
                'content' => '/sounds/23_music.mp3'
            ],
            [
                'name' => '[TRILHA - MEDIEVAL] A Baroque Letter - Aaron Kenny',
                'content' => '/sounds/24_music.mp3'
            ],
            [
                'name' => '[TRILHA - MEDIEVAL] Bourree - Joel Cummins',
                'content' => '/sounds/25_music.mp3'
            ],
            [
                'name' => '[TRILHA - MEDIEVAL] Invitation to the Castle Ball - Doug Maxwell',
                'content' => '/sounds/26_music.mp3'
            ],
            [
                'name' => '[TRILHA - MEDIEVAL] Yonder Hill and Dale - Aaron Kenny',
                'content' => '/sounds/27_music.mp3'
            ],
        ];

        collect($sounds)->each(function ($sound) {
            Sound::create($sound);
        });
    }
}
