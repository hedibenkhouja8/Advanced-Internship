<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=InventoryRepository::class)
 */
class Inventory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "This field must be at least {{ limit }} characters long",
     *      maxMessage = "This field cannot be longer than {{ limit }} characters",
       
     * )
     */
    private $Equipment;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = " This field must be at least {{ limit }} characters long",
     *      maxMessage = "This fieldcannot be longer than {{ limit }} characters",
       
     * )
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Locaation;

    /**
     * @ORM\Column(type="text", nullable=true)
     *  * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = " This field must be at least {{ limit }} characters long",
     *      maxMessage = "This fieldcannot be longer than {{ limit }} characters",
       
     * )
     */
    private $Notes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $OperatingSystem;

    /**
     * @ORM\Column(type="string", length=255)
     *  * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = " This field must be at least {{ limit }} characters long",
     *      maxMessage = "This fieldcannot be longer than {{ limit }} characters",
       
     * )
     */
    private $State;

    /**
     * @ORM\Column(type="string", length=255)
     *  * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = " This field must be at least {{ limit }} characters long",
     *      maxMessage = "This fieldcannot be longer than {{ limit }} characters",
       
     * )
     */
    private $Brand;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = " This field must be at least {{ limit }} characters long",
     *      maxMessage = "This fieldcannot be longer than {{ limit }} characters",
       
     * )
     */
    private $Model;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PurchaseDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Supplier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LastScan;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LastMaintenance;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $CreatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipment(): ?string
    {
        return $this->Equipment;
    }

    public function setEquipment(string $Equipment): self
    {
        $this->Equipment = $Equipment;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->User;
    }

    public function setUser(string $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getLocaation(): ?string
    {
        return $this->Locaation;
    }

    public function setLocaation(string $Locaation): self
    {
        $this->Locaation = $Locaation;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->Notes;
    }

    public function setNotes(?string $Notes): self
    {
        $this->Notes = $Notes;

        return $this;
    }

    public function getOperatingSystem(): ?string
    {
        return $this->OperatingSystem;
    }

    public function setOperatingSystem(?string $OperatingSystem): self
    {
        $this->OperatingSystem = $OperatingSystem;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->State;
    }

    public function setState(string $State): self
    {
        $this->State = $State;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->Brand;
    }

    public function setBrand(string $Brand): self
    {
        $this->Brand = $Brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->Model;
    }

    public function setModel(?string $Model): self
    {
        $this->Model = $Model;

        return $this;
    }

    public function getPurchaseDate(): ?string
    {
        return $this->PurchaseDate;
    }

    public function setPurchaseDate(?string $PurchaseDate): self
    {
        $this->PurchaseDate = $PurchaseDate;

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

    public function getLastScan(): ?string
    {
        return $this->LastScan;
    }

    public function setLastScan(?string $LastScan): self
    {
        $this->LastScan = $LastScan;

        return $this;
    }

    public function getLastMaintenance(): ?string
    {
        return $this->LastMaintenance;
    }

    public function setLastMaintenance(?string $LastMaintenance): self
    {
        $this->LastMaintenance = $LastMaintenance;

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
}
