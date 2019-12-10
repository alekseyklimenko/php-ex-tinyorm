<?php
namespace TinyORM\Mapper;

class Post extends AbstractMapper
{
    private $mapping = [
        'id' => 'id',
        'title' => 'title',
        'content' => 'content',
    ];

    public function getIdColumn()
    {
        return $this->mapping['id'];
    }
}
