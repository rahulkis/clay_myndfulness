<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                     => $this->id,
            'active_plan'            => $this->activePlan ?? [],
            'name'                   => $this->name,
            'email'                  => $this->email,
            'avatar'                 => $this->avatar,
            'is_onboard_completed'   => $this->is_onboard_completed,
            'habit_medals'           => $this->habit_medals,
            'habit_coins'            => $this->habit_coins,
            'self_assessment_medals' => $this->self_assessment_medals,
            'self_assessment_coins'  => $this->self_assessment_coins,
            'daily_journal_medals'   => $this->daily_journal_medals,
            'daily_journal_coins'    => $this->daily_journal_coins,
            'total_medals'           => $this->total_medals,
            'total_coins'            => $this->total_coins,
            'time_zone'              => $this->time_zone,
            'created_at'             => $this->created_at,
            'updated_at'             => $this->updated_at,
        ];
    }
}
