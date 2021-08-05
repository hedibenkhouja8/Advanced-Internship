<?php

namespace App\Entity;

use App\Repository\LicenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LicenceRepository::class)
 */
class Licence
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
    private $Product_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Supplier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Compilance_type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $User;

    /**
     * @ORM\Column(type="date")
     */
    private $Purchase_date;

    /**
     * @ORM\Column(type="date")
     */
    private $expiration_date;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $CreatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="licence")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->Product_name;
    }

    public function setProductName(string $Product_name): self
    {
        $this->Product_name = $Product_name;

        return $this;
    }

    public function getSupplier(): ?string
    {
        return $this->Supplier;
    }

    public function setSupplier(?string $Supplier): self
    {
        $this->Supplier = $Supplier;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(?string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getCompilanceType(): ?string
    {
        return $this->Compilance_type;
    }

    public function setCompilanceType(?string $Compilance_type): self
    {
        $this->Compilance_type = $Compilance_type;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->User;
    }

    public function setUser(?string $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->Purchase_date;
    }

    public function setPurchaseDate(\DateTimeInterface $Purchase_date): self
    {
        $this->Purchase_date = $Purchase_date;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(\DateTimeInterface $expiration_date): self
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
