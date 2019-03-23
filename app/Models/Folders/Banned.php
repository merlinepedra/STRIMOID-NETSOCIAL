<?php

namespace Strimoid\Models\Folders;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Strimoid\Models\FakeFolder;

class Banned extends FakeFolder
{
    public $isPrivate = true;

    protected function getBuilder(string $model): Builder
    {
        if (Auth::guest()) {
            redirect()->guest('login');
        }

        $builder = with(new $model())->newQuery();

        $bannedGroups = Auth::user()->bannedGroups()->pluck('id');
        $builder->whereIn('group_id', $bannedGroups);

        return $builder;
    }
}
