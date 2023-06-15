<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('fetchUserEvaluations')]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('fetchUserEvaluations')]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('fetchUserEvaluations')]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('fetchUserEvaluations')]
    private ?Quiz $quiz = null;

    #[ORM\OneToMany(mappedBy: 'evaluation', targetEntity: Copie::class, orphanRemoval: true)]
    private Collection $copies;

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('fetchUserEvaluations')]
    private ?Formation $formation = null;

    #[ORM\Column]
    #[Groups('fetchUserEvaluations')]
    private ?bool $estCloture = null;

    public function __construct()
    {
        $this->copies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * @return Collection<int, Copie>
     */
    public function getCopies(): Collection
    {
        return $this->copies;
    }

    public function addCopy(Copie $copy): self
    {
        if (!$this->copies->contains($copy)) {
            $this->copies->add($copy);
            $copy->setEvaluation($this);
        }

        return $this;
    }

    public function removeCopy(Copie $copy): self
    {
        if ($this->copies->removeElement($copy)) {
            // set the owning side to null (unless already changed)
            if ($copy->getEvaluation() === $this) {
                $copy->setEvaluation(null);
            }
        }

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function isEstCloture(): ?bool
    {
        return $this->estCloture;
    }

    public function setEstCloture(bool $estCloture): self
    {
        $this->estCloture = $estCloture;

        return $this;
    }

    public function isEnCours(): bool
    {
        $enCours = false;

        $now = new \DateTime();
        if ($this->getDateDebut() <= $now && $this->getDateFin() >= $now) {
            $enCours = true;
        }

        return $enCours;
    }

    public function isACorriger(): bool
    {
        $corrig = false;

        $now = new \DateTime();
        if ($this->getDateFin() < $now && !$this->isEstCloture()) {
            $corrig = true;
        }

        return $corrig;
    }
}
