<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\EntityListeners(['App\EntityListener\UtilisateurListener'])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email()]
    #[Assert\Length(min: 2, max: 180)]
    private ?string $email;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Assert\NotNull()]
    private array $roles = [];

    private ?string $plainPassword = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?string $password = "password";

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $created_at = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToOne(targetEntity: "App\Entity\UtilisateurDetails", mappedBy: "utilisateur", cascade: ["persist", "remove"])]
    private $utilisateurDetails;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

        /**
     * Get the value of plainPassword
     */ 
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */ 
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->is_active;
    }

    public function setActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUtilisateurDetails(): ?UtilisateurDetails
{
    return $this->utilisateurDetails;
}

public function setUtilisateurDetails(UtilisateurDetails $utilisateurDetails): self
{
    $this->utilisateurDetails = $utilisateurDetails;

    // set the owning side of the relation if necessary
    if ($utilisateurDetails->getUtilisateur() !== $this) {
        $utilisateurDetails->setUtilisateur($this);
    }

    return $this;
}

public function getUtilisateurDetailsPrenom(): ?string
{
    return $this->utilisateurDetails ? $this->utilisateurDetails->getPrenom() : null;
}

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

}
