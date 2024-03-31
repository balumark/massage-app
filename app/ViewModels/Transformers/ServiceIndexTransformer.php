<?php

namespace App\ViewModels\Transformers;

use App\Models\Service;

class ServiceIndexTransformer
{
    const ORDINARY_USER_PRICE_CALC_VALUE = 1.27;
    const VIP_USER_PRICE_CALC_VALUE = 0.8;

    
    public function transform(Service $service)
    {
        return [
            'id' => $service->id,
            'title' => $service->title,
            'price' => $this->getServicePriceByAuthUser($service->price),
        ];
    }

    private function getServicePriceByAuthUser(int $price): float
    {
        // dd(auth()->user()->isVip());
        if (auth()->user()->isVip()) {
            return $price * self::VIP_USER_PRICE_CALC_VALUE;
        }
        return $price * self::ORDINARY_USER_PRICE_CALC_VALUE;
    }
}
