<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reponse = null;

    #[ORM\Column]
    private ?bool $repChoix1 = null;

    #[ORM\Column]
    private ?bool $repChoix2 = null;

    #[ORM\Column]
    private ?bool $repChoix3 = null;

    #[ORM\Column]
    private ?bool $repChoix4 = null;

    #[ORM\Column(nullable: true)]
    private ?float $note = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $annotation = null;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Copie $idCopie = null;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $idQuestion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(?string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function isRepChoix1(): ?bool
    {
        return $this->repChoix1;
    }

    public function setRepChoix1(bool $repChoix1): self
    {
        $this->repChoix1 = $repChoix1;

        return $this;
    }

    public function isRepChoix2(): ?bool
    {
        return $this->repChoix2;
    }

    public function setRepChoix2(bool $repChoix2): self
    {
        $this->repChoix2 = $repChoix2;

        return $this;
    }

    public function isRepChoix3(): ?bool
    {
        return $this->repChoix3;
    }

    public function setRepChoix3(bool $repChoix3): self
    {
        $this->repChoix3 = $repChoix3;

        return $this;
    }

    public function isRepChoix4(): ?bool
    {
        return $this->repChoix4;
    }

    public function setRepChoix4(bool $repChoix4): self
    {
        $this->repChoix4 = $repChoix4;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getAnnotation(): ?string
    {
        return $this->annotation;
    }

    public function setAnnotation(?string $annotation): self
    {
        $this->annotation = $annotation;

        return $this;
    }

    public function getIdCopie(): ?Copie
    {
        return $this->idCopie;
    }

    public function setIdCopie(?Copie $idCopie): self
    {
        $this->idCopie = $idCopie;

        return $this;
    }

    public function getIdQuestion(): ?Question
    {
        return $this->idQuestion;
    }

    public function setIdQuestion(?Question $idQuestion): self
    {
        $this->idQuestion = $idQuestion;

        return $this;
    }
}
