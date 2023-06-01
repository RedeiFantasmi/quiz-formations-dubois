<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['fetchFormateurQuiz', 'fetchQuizData', 'fetchQuizQuestions'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['fetchFormateurQuiz', 'fetchQuizData', 'fetchQuizQuestions'])]
    private ?float $noteMax = null;

    #[ORM\Column(length: 255)]
    #[Groups(['fetchFormateurQuiz', 'fetchQuizData', 'fetchQuizQuestions'])]
    private ?string $enonce = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['fetchFormateurQuiz', 'fetchQuizQuestions'])]
    private ?string $choix1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['fetchFormateurQuiz', 'fetchQuizQuestions'])]
    private ?string $choix2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['fetchFormateurQuiz', 'fetchQuizQuestions'])]
    private ?string $choix3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['fetchFormateurQuiz', 'fetchQuizQuestions'])]
    private ?string $choix4 = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['fetchFormateurQuiz', 'fetchQuizData', 'fetchQuizQuestions'])]
    private ?TypeQuestion $type = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Reponse::class, orphanRemoval: true)]
    private Collection $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoteMax(): ?float
    {
        return $this->noteMax;
    }

    public function setNoteMax(float $noteMax): self
    {
        $this->noteMax = $noteMax;

        return $this;
    }

    public function getEnonce(): ?string
    {
        return $this->enonce;
    }

    public function setEnonce(string $enonce): self
    {
        $this->enonce = $enonce;

        return $this;
    }

    public function getChoix1(): ?string
    {
        return $this->choix1;
    }

    public function setChoix1(?string $choix1): self
    {
        $this->choix1 = $choix1;

        return $this;
    }

    public function getChoix2(): ?string
    {
        return $this->choix2;
    }

    public function setChoix2(string $choix2): self
    {
        $this->choix2 = $choix2;

        return $this;
    }

    public function getChoix3(): ?string
    {
        return $this->choix3;
    }

    public function setChoix3(?string $choix3): self
    {
        $this->choix3 = $choix3;

        return $this;
    }

    public function getChoix4(): ?string
    {
        return $this->choix4;
    }

    public function setChoix4(?string $choix4): self
    {
        $this->choix4 = $choix4;

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

    public function getType(): ?TypeQuestion
    {
        return $this->type;
    }

    public function setType(?TypeQuestion $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
            $reponse->setQuestion($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestion() === $this) {
                $reponse->setQuestion(null);
            }
        }

        return $this;
    }
}
