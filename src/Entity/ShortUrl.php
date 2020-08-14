<?php

namespace App\Entity;

use App\Repository\ShortUrlRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=ShortUrlRepository::class)
 * @UniqueEntity(
 *     fields={"short"},
 *     errorPath="stats",
 *     message="This short code is already in use."
 * )
 */
class ShortUrl
{
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @Assert\NotBlank
   * @Assert\Url
   * @ORM\Column(type="string", length=255)
   */
  private $url;

  /**
   * @Assert\Length(
   *      min = 5,
   *      max = 9,
   *      minMessage = "Must be at least {{ limit }} characters long",
   *      maxMessage = "Cannot be longer than {{ limit }} characters",
   *      allowEmptyString = false
   * )
   * @ORM\Column(type="string", length=9, unique=true)
   */
  private $short;

  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $count;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getUrl()
  {
    return $this->url;
  }

  public function setUrl(string $url)
  {
    $this->url = $url;
  }

  public function getShort()
  {
    return $this->short;
  }

  public function setShort(string $short)
  {
    $this->short = $short;
  }

  public function getCount(): ?int
  {
      return $this->count;
  }

  public function setCount(?int $count): self
  {
      $this->count = $count;

      return $this;
  }
}
