<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\OneToMany(targetEntity=licence::class, mappedBy="category")
     */
    private $licence;

    public function __construct()
    {
        $this->licence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection|licence[]
     */
    public function getLicence(): Collection
    {
        return $this->licence;
    }

    public function addLicence(licence $licence): self
    {
        if (!$this->licence->contains($licence)) {
            $this->licence[] = $licence;
            $licence->setCategory($this);
        }

        return $this;
    }

    public function removeLicence(licence $licence): self
    {
        if ($this->licence->removeElement($licence)) {
            // set the owning side to null (unless already changed)
            if ($licence->getCategory() === $this) {
                $licence->setCategory(null);
            }
        }

        return $this;
    }
}
