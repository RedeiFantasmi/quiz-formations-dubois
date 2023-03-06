<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $idQuiz = null;

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etat $idEtat = null;

    #[ORM\ManyToMany(targetEntity: Formation::class, inversedBy: 'evaluations')]
    private Collection $idFormation;

    #[ORM\OneToMany(mappedBy: 'idEvaluation', targetEntity: Copie::class, orphanRemoval: true)]
    private Collection $copies;

    public function __construct()
    {
        $this->idFormation = new ArrayCollection();
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

    public function getIdQuiz(): ?Quiz
    {
        return $this->idQuiz;
    }

    public function setIdQuiz(?Quiz $idQuiz): self
    {
        $this->idQuiz = $idQuiz;

        return $this;
    }

    public function getIdEtat(): ?Etat
    {
        return $this->idEtat;
    }

    public function setIdEtat(?Etat $idEtat): self
    {
        $this->idEtat = $idEtat;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getIdFormation(): Collection
    {
        return $this->idFormation;
    }

    public function addIdFormation(Formation $idFormation): self
    {
        if (!$this->idFormation->contains($idFormation)) {
            $this->idFormation->add($idFormation);
        }

        return $this;
    }

    public function removeIdFormation(Formation $idFormation): self
    {
        $this->idFormation->removeElement($idFormation);

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
            $copy->setIdEvaluation($this);
        }

        return $this;
    }

    public function removeCopy(Copie $copy): self
    {
        if ($this->copies->removeElement($copy)) {
            // set the owning side to null (unless already changed)
            if ($copy->getIdEvaluation() === $this) {
                $copy->setIdEvaluation(null);
            }
        }

        return $this;
    }
}
