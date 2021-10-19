<?php

namespace App\Models\Collections;

use App\Models\Tag;

class TagsCollection
{
    private array $tags = [];

    public function __construct(array $items)
    {
        foreach ($items as $item) {
            $this->add(
                new Tag(
                    $item['id'],
                    $item['name']
                )
            );
        }
    }

    public function add(Tag $tag): void
    {
        $this->tags[$tag->getId()] = $tag;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

}