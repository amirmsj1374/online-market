<?php

namespace Modules\Template\Interfaces;

use Modules\Template\Entities\Content;
use Modules\Template\Entities\Section;

interface ContentRepositoryInterface
{
    public function createMultipleContents(Section $section, $item); // item is array of request data related to one content
    public function createContent(Section $section, $data);
    public function find($contentId);
    public function update($content, $item); // item is array of request data related to one content
    public function updateProductContent($content, $item);
    public function delete($id);
}
