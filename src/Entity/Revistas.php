<?php

namespace App\Entity;

use App\Repository\RevistasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: RevistasRepository::class)]
class Revistas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(length: 255)]
    private string|bool|null $revista;

    #[ORM\Column]
    #[Gedmo\Timestampable(on:"create")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Gedmo\Timestampable(on:"update")]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $fragmento = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getRevista(): ?string
    {
        return $this->revista;
    }

    public function setRevista(string $revista): self
    {
        $this->revista = $revista;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getFragmento(): ?string
    {
        return $this->fragmento;
    }

    public function setFragmento(string $fragmento): self
    {
        $this->fragmento = $fragmento;

        return $this;
    }
}
