<?php

use Modules\Template\Entities\Page;
use Modules\Template\Interfaces\PageRepositoryInterface;

class PageRepository implements PageRepositoryInterface {
    public function find(Page $page)
    {
        return $page;
    }
}
