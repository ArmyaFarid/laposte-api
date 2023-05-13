<?php

namespace App\Entity;

use App\Repository\ImportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ImportRepository::class)]
class Import
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getTransactions","getClient","getDetailClient"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(["getTransactions","getClient","getDetailClient"])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    #[Groups(["getTransactions","getClient","getDetailClient"])]
    private ?int $range_5 = null;

    #[ORM\Column]
    #[Groups(["getTransactions","getClient","getDetailClient"])]
    private ?int $range_10 = null;

    #[ORM\Column]
    #[Groups(["getTransactions","getClient","getDetailClient"])]
    private ?int $range_15 = null;

    #[ORM\Column]
    #[Groups(["getTransactions","getClient","getDetailClient"])]
    private ?int $range_20 = null;

    #[ORM\Column]
    #[Groups(["getTransactions","getClient","getDetailClient"])]
    private ?int $range_25 = null;

    #[ORM\Column]
    #[Groups(["getTransactions","getClient","getDetailClient"])]
    private ?int $range_30 = null;

    #[ORM\ManyToOne(inversedBy: 'imports')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["getTransactions"])]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRange5(): ?int
    {
        return $this->range_5;
    }

    public function setRange5(int $range_5): self
    {
        $this->range_5 = $range_5;

        return $this;
    }

    public function getRange10(): ?int
    {
        return $this->range_10;
    }

    public function setRange10(int $range_10): self
    {
        $this->range_10 = $range_10;

        return $this;
    }

    public function getRange15(): ?int
    {
        return $this->range_15;
    }

    public function setRange15(int $range_15): self
    {
        $this->range_15 = $range_15;

        return $this;
    }

    public function getRange20(): ?int
    {
        return $this->range_20;
    }

    public function setRange20(int $range_20): self
    {
        $this->range_20 = $range_20;

        return $this;
    }

    public function getRange25(): ?int
    {
        return $this->range_25;
    }

    public function setRange25(int $range_25): self
    {
        $this->range_25 = $range_25;

        return $this;
    }

    public function getRange30(): ?int
    {
        return $this->range_30;
    }

    public function setRange30(int $range_30): self
    {
        $this->range_30 = $range_30;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
