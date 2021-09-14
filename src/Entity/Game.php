<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="games")
     */
    private $challengers;

    /**
     * @ORM\OneToMany(targetEntity=Bet::class, mappedBy="game")
     */
    private $bets;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="winningGames")
     */
    private $winner;

    public function __construct()
    {
        $this->challengers = new ArrayCollection();
        $this->bets = new ArrayCollection();
    }


    // FUNCTIONS

    public function fight(): self {
        $fightWinner = rand(0,1);
        $this->setWinner($this->getChallengers()[$fightWinner]);

        return $this;
        
    }





    // GETTERS AND SETTERS

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getChallengers(): Collection
    {
        return $this->challengers;
    }

    public function addChallenger(User $challenger): self
    {
        if (
            !$this->challengers->contains($challenger) &&
            in_array('ROLE_CHALLENGER', $challenger->getRoles()) &&
            count($this->challengers) <= 2
        ) {
            $this->challengers[] = $challenger;
        }

        return $this;
    }

    public function removeChallenger(User $challenger): self
    {
        $this->challengers->removeElement($challenger);

        return $this;
    }

    /**
     * @return Collection|Bet[]
     */
    public function getBets(): Collection
    {
        return $this->bets;
    }

    public function addBet(Bet $bet): self
    {
        if (!$this->bets->contains($bet)) {
            $this->bets[] = $bet;
            $bet->setGame($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): self
    {
        if ($this->bets->removeElement($bet)) {
            // set the owning side to null (unless already changed)
            if ($bet->getGame() === $this) {
                $bet->setGame(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWinner(): ?User
    {
        return $this->winner;
    }

    public function setWinner(?User $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    
}
