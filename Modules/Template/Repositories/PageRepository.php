<?php

namespace Modules\Template\Repositories;

use Illuminate\Support\Facades\Log;
use Modules\Template\Entities\Page;
use Modules\Template\Interfaces\PageRepositoryInterface;

class PageRepository implements PageRepositoryInterface {
    public function find(Page $page)
    {
        Log::info([
            'page indside ' => $page
        ]);
        return $page;
    }
}
