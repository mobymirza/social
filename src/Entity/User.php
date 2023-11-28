<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $VerificationCode = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isVerified = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $bio = null;

    #[ORM\ManyToMany(targetEntity: self::class,mappedBy:'followings')]
    private Collection $followers;

    #[ORM\ManyToMany(targetEntity: self::class,inversedBy:'followers')]
    private Collection $followings;

    #[ORM\Column(length: 255)]
    private ?string $user_name = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Post::class)]
    private Collection $post;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Like::class, orphanRemoval: true)]
    private Collection $likes;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Comments::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\OneToMany(mappedBy: 'user_sender', targetEntity: Message::class)]
    private Collection $sender;

    #[ORM\OneToMany(mappedBy: 'user_recive', targetEntity: Message::class)]
    private Collection $recive;

    public function __construct(string $email,string $password,string $VerificationCode,string $name,string $image,string $bio,string $user_name)
    {
        $this->email = $email;
        $this->password = $password;
        $this->VerificationCode = $VerificationCode;
        $this->name = $name;
        $this->image = $image;
        $this->bio = $bio;
        $this->followers = new ArrayCollection();
        $this->followings = new ArrayCollection();
        $this->user_name = $user_name;
        $this->post = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->sender = new ArrayCollection();
        $this->recive = new ArrayCollection();

    }

    /**
     * @return string|null
     */
    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function setUserName(string $user_name): void
    {
        $this->user_name = $user_name;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getVerificationCode(): ?string
    {
        return $this->VerificationCode;
    }

    public function setVerificationCode(?string $VerificationCode): static
    {
        $this->VerificationCode = $VerificationCode;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(?bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(self $follower): static
    {
        if (!$this->followers->contains($follower)) {
            $this->followers->add($follower);
        }

        return $this;
    }

    public function removeFollower(self $follower): static
    {
        $this->followers->removeElement($follower);

        return $this;
    }
    /**
     * @return Collection
     */
    public function getFollowings(): Collection
    {
        return $this->followings;
    }

    public function addFollowing(self $following): static
    {
        if (!$this->followings->contains($following)) {
            $this->followings->add($following);
        }

        return $this;
    }

    public function removeFollowing(self $following): static
    {
        $this->followings->removeElement($following);

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPost(): Collection
    {
        return $this->post;
    }

    public function addPost(Post $post): static
    {
        if (!$this->post->contains($post)) {
            $this->post->add($post);
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->post->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Like>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setUser($this);
        }

        return $this;
    }

    public function removeLike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getUser() === $this) {
                $like->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setUserId($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUserId() === $this) {
                $comment->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getSender(): Collection
    {
        return $this->sender;
    }

    public function addSender(Message $sender): static
    {
        if (!$this->sender->contains($sender)) {
            $this->sender->add($sender);
            $sender->setUserSender($this);
        }

        return $this;
    }

    public function removeSender(Message $sender): static
    {
        if ($this->sender->removeElement($sender)) {
            // set the owning side to null (unless already changed)
            if ($sender->getUserSender() === $this) {
                $sender->setUserSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getRecive(): Collection
    {
        return $this->recive;
    }

    public function addRecive(Message $recive): static
    {
        if (!$this->recive->contains($recive)) {
            $this->recive->add($recive);
            $recive->setUserRecive($this);
        }

        return $this;
    }

    public function removeRecive(Message $recive): static
    {
        if ($this->recive->removeElement($recive)) {
            // set the owning side to null (unless already changed)
            if ($recive->getUserRecive() === $this) {
                $recive->setUserRecive(null);
            }
        }

        return $this;
    }
}
