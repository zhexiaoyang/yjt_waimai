<?php

namespace App\Observers;

use App\Models\Shop;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored
// getAttributes 提交的   getOriginal 原来的

class ShopObserver
{
//    public function saving(Shop $shop)
//    {
//        $wm_shop = new WmShp(config('wmconfig.meituan'));
//        $meituan = $wm_shop['mt'];
//        $params = [
//            'app_poi_code' => $shop->meituan_id,
//        ];
//        $old = $shop->getOriginal();
//        if (!empty($old))
//        {
//            foreach ($old as $k => $v) {
//                $params['name'] = $shop->name;
//                $params['address'] = $shop->address;
//                $params['longitude'] = $shop->longitude;
//                $params['latitude'] = $shop->latitude;
//                $params['phone'] = $shop->phone;
//                $params['standby_tel'] = $shop->standby_tel;
//                $params['shipping_fee'] = $shop->shipping_fee;
//                $params['shipping_time'] = $shop->shipping_time;
//                $params['promotion_info'] = $shop->promotion_info;
//                $params['open_level'] = $shop->open_level;
//                $params['is_online'] = $shop->is_online;
//                $params['invoice_support'] = $shop->invoice_support;
//                $params['invoice_min_price'] = $shop->invoice_min_price;
//                $params['invoice_description'] = $shop->invoice_description;
//            }
//        }
//
//        $result = $meituan->save($params);
//
//        if ($result['data'] != 'ok')
//        {
//            $error_msg = isset($result['error']['msg'])?$result['error']['msg']:'接口返回错误';
//            throw new \Exception($error_msg);
//        }
//    }
}