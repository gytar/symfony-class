<?php

namespace App\Entity;

use App\Repository\BetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BetRepository::class)
 */
class Bet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="bets")
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bets")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="challengerBet")
     */
    private $challenger;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        if (in_array('ROLE_GAMBLER', $user->getRoles())) {
            $this->user = $user;
            return $this;
        }
        throw new \Exception('User is not a gambler, so cannot gamble', 1);
    }

    public function getChallenger(): ?User
    {
        return $this->challenger;
    }

    public function setChallenger(?User $challenger): self
    {
        
        if (in_array('ROLE_GAMBLER', $challenger->getRoles())) {
            $this->challenger = $challenger;
            return $this;
        }
        throw new \Exception('User is not a gambler, so cannot gamble', 1);
    }
}
