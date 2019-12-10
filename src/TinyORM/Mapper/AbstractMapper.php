<?php
namespace TinyORM\Mapper;

abstract class AbstractMapper
{
    private $mapping = [];
    abstract public function getIdColumn();

    public function populate(array $data, $entity)
    {
        $mappingsFlipped = array_flip($this->mapping);
        foreach ($data as $key => $value) {
            if (isset($mappingsFlipped[$key])) {
                call_user_func_array(
                    [$entity, 'set' . ucfirst($mappingsFlipped[$key])],
                    [$value]
                );
            }
        }
        return $entity;
    }

    public function extract($entity)
    {
        $data = [];
        foreach ($this->mapping as $keyObject => $keyColumn) {
            if ($keyColumn != $this->getIdColumn()) {
                $data[$keyColumn] = call_user_func([$entity, 'get' . ucfirst($keyObject)]);
            }
        }
        return $data;
    }
}
