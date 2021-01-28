<?php

namespace AxlMedia\SportradarSdk;

use Illuminate\Pagination\LengthAwarePaginator as BasePaginator;

class Paginator extends BasePaginator
{
    /**
     * Determine if the paginator is on the first page.
     *
     * @return bool
     */
    public function onFirstPage()
    {
        return $this->currentPage() <= 0;
    }
}
