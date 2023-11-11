<?php

namespace App\Http\Services;

use App\Models\Attribute;

class AttributesService
{
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


    public function mapAttributesPoints($allAttributes)
    {
        return collect($allAttributes)->mapWithKeys(function ($attribute) {
            if (Attribute::hasCurrentPoints($attribute['id'])) {
                $data = [
                    'total_points' => $attribute['totalPoints'],
                    'current_points' => $attribute['currentPoints']
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
}
