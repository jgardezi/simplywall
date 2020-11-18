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
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'uniqueSymbol'        => $this->unique_symbol,
            'lastKnowSharePrice'  => (float)$this->lastKnowPrice()->first()->price,
            'snowFlakeScoreTotal' => (int)$this->score->total,
        ];
    }
}
