<?php

declare(strict_types=1);

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class PostBuilder extends Builder
{
    public function __construct(\Illuminate\Database\Query\Builder $query)
    {
        parent::__construct($query);
    }

    public function trend(): Builder
    {
        return $this->orderBy('views', 'desc');
    }
}
