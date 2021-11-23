<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'type' => 'orders',
            'id' => $this->id,
            'attributes' => [
                'voucher_id' =>$this->voucher_id,
                'voucher_amount' => (string) $this->voucher_amount,
                'sub_total' => (string) $this->sub_total,
                'total' => (string) $this->total,
                'currency_id' => $this->currency_id,
                'currency' => $this->currency->getTranslation('title', userLanguage()),
                'status' => $this->status,
                'contact_name' => $this->contact_name,
                'contact_mobile' => $this->contact_mobile,
                'full_address' => $this->full_address,
                'created_at' =>($this->created_at)?:date('Y-m-y H:i:s')
            ],
            'relationships' => [
                'products' => $this->products_list,
            ],
        ];
    }

}
