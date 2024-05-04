<?php

namespace App\Traits;

use DeviceDetector\Parser\Client\Browser;
use Exception;

trait StoreHeaders
{

    public function storeHeaders($model): void
    {
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );

        try {
            if (class_exists(Browser::class)) {
                $model->headers = json_encode(\Browser::detect()->toArray(), JSON_PRETTY_PRINT);

                if (!in_array(request()->ip(), $whitelist)) {
                    $model->register_ip = request()->ip();
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}
