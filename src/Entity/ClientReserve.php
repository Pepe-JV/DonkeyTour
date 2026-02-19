<?php

namespace App\Entity;

use App\Repository\ClientReserveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientReserveRepository::class)]
class ClientReserve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $asist = null;

    /**
     * @var Collection<int, Reserve>
     */
    #[ORM\OneToMany(targetEntity: Reserve::class, mappedBy: 'clientReserve')]
    private Collection $reserve;

    public function __construct()
    {
        $this->reserve = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAsist(): ?bool
    {
        return $this->asist;
    }

    public function setAsist(bool $asist): static
    {
        $this->asist = $asist;

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
            $reserve->setClientReserve($this);
        }

        return $this;
    }

    public function removeReserve(Reserve $reserve): static
    {
        if ($this->reserve->removeElement($reserve)) {
            // set the owning side to null (unless already changed)
            if ($reserve->getClientReserve() === $this) {
                $reserve->setClientReserve(null);
            }
        }

        return $this;
    }
}
