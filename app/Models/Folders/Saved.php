<?php

namespace Strimoid\Models\Folders;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Strimoid\Models\FakeFolder;

class Saved extends FakeFolder
{
    public $isPrivate = true;

    protected function getBuilder(string $model): Builder
    {
        $builder = with(new $model())->newQuery();
        $builder->whereHas('saves', function ($q): void {
            $q->where('user_id', Auth::id());
        });

        return $builder;
    }
}
