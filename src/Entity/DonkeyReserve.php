<?php

namespace App\Entity;

use App\Repository\DonkeyReserveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonkeyReserveRepository::class)]
class DonkeyReserve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Donkey>
     */
    #[ORM\OneToMany(targetEntity: Donkey::class, mappedBy: 'reserve')]
    private Collection $donkeys;

    /**
     * @var Collection<int, Reserve>
     */
    #[ORM\OneToMany(targetEntity: Reserve::class, mappedBy: 'donkeyReserve')]
    private Collection $reserve;

    public function __construct()
    {
        $this->donkeys = new ArrayCollection();
        $this->reserve = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Donkey>
     */
    public function getDonkeys(): Collection
    {
        return $this->donkeys;
    }

    public function addDonkey(Donkey $donkey): static
    {
        if (!$this->donkeys->contains($donkey)) {
            $this->donkeys->add($donkey);
            $donkey->setReserve($this);
        }

        return $this;
    }

    public function removeDonkey(Donkey $donkey): static
    {
        if ($this->donkeys->removeElement($donkey)) {
            // set the owning side to null (unless already changed)
            if ($donkey->getReserve() === $this) {
                $donkey->setReserve(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reserve>
     */
    public function getReserve(): Collection
    {
        return $this->reserve;
    }

    public function addReserve(Reserve $reserve): static
    {
        if (!$this->reserve->contains($reserve)) {
            $this->reserve->add($reserve);
            $reserve->setDonkeyReserve($this);
        }

        return $this;
    }

    public function removeReserve(Reserve $reserve): static
    {
        if ($this->reserve->removeElement($reserve)) {
            // set the owning side to null (unless already changed)
            if ($reserve->getDonkeyReserve() === $this) {
                $reserve->setDonkeyReserve(null);
            }
        }

        return $this;
    }
}
