<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Company extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $scoreTotal         = (int)$this->whenLoaded('score')->total;
        $lastKnowSharePrice = (float)$this->whenLoaded('prices')->sortDesc()->first()->price;

        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'uniqueSymbol'        => $this->unique_symbol,
            'exchangeSymbol'      => $this->exchange_symbol,
            'lastKnowSharePrice'  => $lastKnowSharePrice,
            'snowFlakeScoreTotal' => $scoreTotal,
        ];
    }
}
