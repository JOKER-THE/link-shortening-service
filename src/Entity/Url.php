<?php

namespace App\Entity;

use App\Repository\UrlRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UrlRepository::class)
 */
class Url
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $original_url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $new_link;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalUrl(): ?string
    {
        return $this->original_url;
    }

    public function setOriginalUrl(string $original_url): self
    {
        $this->original_url = $original_url;

        return $this;
    }

    public function getNewLink(): ?string
    {
        return $this->new_link;
    }

    public function setNewLink(string $new_link): self
    {
        $this->new_link = $new_link;

        return $this;
    }
}
