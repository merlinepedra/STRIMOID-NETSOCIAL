<?php

namespace Strimoid\Models;

class UserSetting extends BaseModel
{
    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'user_settings';
    protected array $primaryKeys = ['key', 'user_id'];

    protected static $unguarded = true;

    protected function setKeysForSaveQuery($query): Builder
    {
        foreach ($this->primaryKeys as $key) {
            if (!$this->$key) {
                throw new \Exception(__METHOD__ . 'Missing part of the primary key: ' . $key);
            }

            $query->where($key, '=', $this->$key);
        }

        return $query;
    }
}
