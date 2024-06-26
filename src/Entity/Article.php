<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['article:read']],
)]
class Article
{

    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ApiProperty(identifier:false)]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['article:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['article:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['article:read'])]
    private ?string $title = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Slug(fields: ['title'])]
    #[Groups(['article:read'])]
    #[ApiProperty(identifier:true)]
    private ?string $slug = null;

    #[ORM\Column]
    #[Groups(['article:read'])]
    private float $readingTime;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['article:read'])]
    private ?string $content = null;

    #[ORM\Column(length: 20)]
    #[Groups(['article:read'])]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[Groups(['article:read'])]
    #[ApiFilter(SearchFilter::class, properties: ['author.id' => 'exact'])]
    private ?Author $author = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['article:read'])]
    private ?\DateTimeImmutable $authoredAt = null;

    #[Groups(['article:read'])]
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getReadingTime(): ?float
    {
        return $this->readingTime;
    }

    public function setReadingTime(float $readingTime): self
    {
        $this->readingTime = $readingTime;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getAuthoredAt(): ?\DateTimeImmutable
    {
        return $this->authoredAt;
    }

    public function setAuthoredAt(?\DateTimeImmutable $authoredAt): static
    {
        $this->authoredAt = $authoredAt;

        return $this;
    }
}
