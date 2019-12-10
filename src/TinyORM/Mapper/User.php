<?php
namespace TinyORM\Mapper;

class User extends AbstractMapper
{
    private $mapping = [
        'id' => 'id',
        'firstName' => 'first_name',
        'lastName' => 'last_name',
        'gender' => 'gender',
        'namePrefix' => 'name_prefix',
    ];

    public function getIdColumn()
    {
        return $this->mapping['id'];
    }
}
