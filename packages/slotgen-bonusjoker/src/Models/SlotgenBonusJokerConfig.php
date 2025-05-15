<?php

namespace Slotgen\SlotgenBonusJoker\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotgenBonusJokerConfig extends Model
{
    use HasFactory;

    protected $table = 'slotgen_bonus_joker_configs';

    protected $fillable = [
        'win_ratio',
        'feature_ratio',
        'feature_winvalue',
        'system_rtp',
        'use_rtp',
        'bet_size',
        'bet_level',
        'base_bet',
        'max_bet',
        'game_name',
        'sign_feature_spin',
        'sign_feature_credit',
        'sign_bonus',
    ];
}
