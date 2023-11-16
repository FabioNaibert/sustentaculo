<?php

namespace App\Http\Services;

use App\Models\Attribute;
use App\Models\Player;
use Exception;
use Illuminate\Support\Facades\Log;

class AttributesService
{
    public const VIDA = 1;
    public const MANA = 2;
    public const ATAQUE = 3;
    public const DEFESA = 4;
    public const SPENT_MANA_PERCENTAGE = 0.2;


    public function mapNewAttributesPoints($allAttributes)
    {
        return collect($allAttributes)->mapWithKeys(function ($attribute) {
            if (Attribute::hasCurrentPoints($attribute['id'])) {
                $data = [
                    'total_points' => $attribute['totalPoints'],
                    'current_points' => $attribute['totalPoints']
                ];
            } else {
                $data = [
                    'total_points' => $attribute['totalPoints'],
                    'current_points' => null
                ];
            }

            return [
                $attribute['id'] => $data
            ];
        });
    }


    public function mapAttributesTotalPoints($allAttributes)
    {
        return collect($allAttributes)->mapWithKeys(function ($attribute) {
            if (Attribute::hasCurrentPoints($attribute['id'])) {
                $data = [
                    'total_points' => $attribute['totalPoints'],
                ];
            } else {
                $data = [
                    'total_points' => $attribute['totalPoints'],
                ];
            }

            return [
                $attribute['id'] => $data
            ];
        });
    }


    public function mapAttributesCurrentPoints($allAttributes)
    {
        return collect($allAttributes)->mapWithKeys(function ($attribute) {
            if (Attribute::hasCurrentPoints($attribute['id'])) {
                $data = [
                    'current_points' => $attribute['currentPoints']
                ];
            } else {
                $data = [
                    'current_points' => null
                ];
            }

            return [
                $attribute['id'] => $data
            ];
        });
    }


    public function weaponAttributes(Player $player)
    {
        $weapon = $player->weaponEquiped;

        $weaponAttributes = $this->getDefaultAttributes();

        if ($weapon) {
            $weaponAttributes = $weapon->attributesPoints->mapWithKeys(function ($attributesPoints) {
                $attribute = $attributesPoints->attribute;
                return [
                    $attribute->id => [
                        'totalPoints' => $attributesPoints->total_points,
                        'id' => $attribute->id,
                    ]
                ];
            });
        }

        return $weaponAttributes;
    }


    public function getDefaultAttributes()
    {
        return Attribute::all()
            ->mapWithKeys(function ($attribute) {
                if (Attribute::hasCurrentPoints($attribute['id'])) {
                    $data = [
                        'totalPoints' => 0,
                        'currentPoints' => 0
                    ];
                } else {
                    $data = [
                        'totalPoints' => 0,
                        'currentPoints' => null
                    ];
                }

                return [
                    $attribute['id'] => $data
                ];
            });
    }


    public function calcHit($allAttributes, $hit)
    {
        $attributes = collect($allAttributes)->keyBy('id')->toArray();
        $hit -= $attributes[self::DEFESA]['totalPoints'];

        if ($hit < 0) {
            $hit = 0;
        }

        $attributes[self::VIDA]['currentPoints'] -= $hit;

        if ($attributes[self::VIDA]['currentPoints'] <= 0) {
            $attributes[self::VIDA]['currentPoints'] = 0;
            $attributes[self::MANA]['currentPoints'] = 0;
        }

        return [
            self::VIDA => [
                'current_points' => $attributes[self::VIDA]['currentPoints']
            ],
            self::MANA => [
                'current_points' => $attributes[self::MANA]['currentPoints']
            ]
        ];
    }


    public function spentMana($allAttributes)
    {
        $attributes = collect($allAttributes)->keyBy('id')->toArray();
        $spent = ceil($attributes[self::MANA]['totalPoints'] * self::SPENT_MANA_PERCENTAGE);

        $attributes[self::MANA]['currentPoints'] -= $spent;

        if ($attributes[self::MANA]['currentPoints'] < 0) {
            throw new Exception('Mana insuficiente.');
        }

        return [
            self::MANA => [
                'current_points' => $attributes[self::MANA]['currentPoints']
            ]
        ];
    }
}
