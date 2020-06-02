<?php

namespace ILOGO\Logoinc\Models;

use Illuminate\Database\Eloquent\Model;
use ILOGO\Logoinc\Events\SettingUpdated;

class Setting extends Model
{
    protected $table = 'settings';

    protected $guarded = [];

    public $timestamps = false;

    protected $dispatchesEvents = [
        'updating' => SettingUpdated::class,
    ];
}
