<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait TUpdatedAt
{

	/**
	 * @var DateTime|NULL
	 * @ORM\Column(type="datetime", nullable=TRUE)
	 */
	protected ?DateTime $updatedAt = null;

	public function getUpdatedAt(): ?DateTime
	{
		return $this->updatedAt;
	}

	/**
	 * Doctrine annotation
	 *
	 * @ORM\PreUpdate
	 * @internal
	 */
	public function setUpdatedAt(): void
	{
		$this->updatedAt = new DateTime();
	}

}
