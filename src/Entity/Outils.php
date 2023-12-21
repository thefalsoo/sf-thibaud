<?php

namespace App\Entity;

use App\Repository\OutilsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Entity(repositoryClass: OutilsRepository::class)]
#[Vich\Uploadable]

class Outils
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $toolUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDePublication = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDeModification = null;

    #[ORM\Column]
    private ?bool $brouillon = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    #[Vich\UploadableField(mapping: 'outils_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;


    #[ORM\ManyToMany(targetEntity: Tag::class)]
    #[ORM\JoinTable(name: "outil_tag")]
    private Collection $tags;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getToolUrl(): ?string
    {
        return $this->toolUrl;
    }

    public function setToolUrl(?string $toolUrl): static
    {
        $this->toolUrl = $toolUrl;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDePublication(): ?\DateTimeInterface
    {
        return $this->dateDePublication;
    }

    public function setDateDePublication(\DateTimeInterface $dateDePublication): static
    {
        $this->dateDePublication = $dateDePublication;

        return $this;
    }

    public function getDateDeModification(): ?\DateTimeInterface
    {
        return $this->dateDeModification;
    }

    public function setDateDeModification(?\DateTimeInterface $dateDeModification): static
    {
        $this->dateDeModification = $dateDeModification;

        return $this;
    }

    public function isBrouillon(): ?bool
    {
        return $this->brouillon;
    }

    public function setBrouillon(bool $brouillon): static
    {
        $this->brouillon = $brouillon;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): static
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->dateDeModification = new \DateTime();
        }

        return $this;
    }



    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
