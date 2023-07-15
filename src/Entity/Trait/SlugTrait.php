<?php
namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
trait SlugTrait
{
    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    /**
     * @return mixed
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug(string $slug): string
    {
        $this->slug = $slug;

        return $this->slug;
    }


}