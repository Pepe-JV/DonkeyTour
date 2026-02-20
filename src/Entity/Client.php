<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends User
{
    /**
     * @var Collection<int, ClientReserve>
     */
    #[ORM\OneToMany(targetEntity: ClientReserve::class, mappedBy: 'clientAssist')]
    private Collection $clientReserves;

    public function __construct()
    {
        $this->clientReserves = new ArrayCollection();
    }

    /**
     * @return Collection<int, ClientReserve>
     */
    public function getClientReserves(): Collection
    {
        return $this->clientReserves;
    }

    public function addClientReserf(ClientReserve $clientReserf): static
    {
        if (!$this->clientReserves->contains($clientReserf)) {
            $this->clientReserves->add($clientReserf);
            $clientReserf->setClientAssist($this);
        }

        return $this;
    }

    public function removeClientReserf(ClientReserve $clientReserf): static
    {
        if ($this->clientReserves->removeElement($clientReserf)) {
            // set the owning side to null (unless already changed)
            if ($clientReserf->getClientAssist() === $this) {
                $clientReserf->setClientAssist(null);
            }
        }

        return $this;
    }
}
