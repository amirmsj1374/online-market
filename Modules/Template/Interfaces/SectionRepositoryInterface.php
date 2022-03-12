<?php

namespace Modules\Template\Interfaces;

interface SectionRepositoryInterface
{
    public function create($element_id, $title);
    public function find($sectionId);
    public function update($section, $data); // data is array with title and status keys
}
