<?php

namespace App\Domain\Store;

class Store
{
    private int $storeId;

    private int $goodsId;

    private int $goodsTypeId;

    private int $assetId;

    private int $cost;

    public function __construct($storeId, $goodsId, $goodsTypeId, $assetId, $cost) {
        $this->storeId = $storeId;
        $this->goodsId = $goodsId;
        $this->goodsTypeId = $goodsTypeId;
        $this->assetId = $assetId;
        $this->cost = $cost;
    }

    public function getGoodsId() {
        return $this->goodsId;
    }
    public function getGoodsTypeId() {
        return $this->goodsTypeId;
    }
    public function getAssetId() {
        return $this->assetId;
    }
    public function getCost() {
        return $this->cost;
    }
}