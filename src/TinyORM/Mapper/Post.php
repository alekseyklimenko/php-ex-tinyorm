<?php
namespace TinyORM\Mapper;

use TinyORM\Entity\Post as PostEntity;

class Post
{
    private $mapping = [
        'id' => 'id',
        'title' => 'title',
        'content' => 'content',
    ];

    public function populate(array $data, PostEntity $post)
    {
        $mappingsFlipped = array_flip($this->mapping);
        foreach ($data as $key => $value) {
            if (isset($mappingsFlipped[$key])) {
                call_user_func_array(
                    [$post, 'set' . ucfirst($mappingsFlipped[$key])],
                    [$value]
                );
            }
        }
        return $post;
    }

    public function extract(PostEntity $post)
    {
        $data = [];
        foreach ($this->mapping as $keyObject => $keyColumn) {
            if ($keyColumn != $this->getIdColumn()) {
                $data[$keyColumn] = call_user_func([$post, 'get' . ucfirst($keyObject)]);
            }
        }
        return $data;
    }

    public function getIdColumn()
    {
        return $this->mapping['id'];
    }
}
