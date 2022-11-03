<?php

namespace App\Filter;

use Illuminate\Database\Eloquent\Builder;
use App\Services\FilterService;
use Illuminate\Support\Arr;

class MemberFilter extends FilterService
{
    public function handle(Builder $builder): Builder
    {
        $this->search($builder);

        return $builder;
    }

    protected function search(Builder $builder): Builder
    {
        $search = Arr::get($this->data, 'search');

        if ($search) {
            $builder->where('name', 'like', "%$search%");
        }

        return $builder;
    }

}
