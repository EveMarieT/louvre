<?php

namespace App\Entity;

use App\Validator\NotAfternoon;
use App\Validator\NotClosed;
use App\Validator\NotFull;
use App\Validator\NotHoliday;
use App\Validator\NotSunday;
use App\Validator\NotTuesday;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 * @NotFull()
 * @NotAfternoon()
 * @NotClosed()
 *
 */
class Booking
{

    const MAX_NB_TICKETS = 10;
    const MIN_NB_TICKETS = 1;
    const NORMAL_DAY = 16;
    const SENIOR_DAY = 12;
    const FREE = 0;
    const CHILD_DAY = 8;
    const REDUCED_PRICE = 10;
    const TYPE_LABEL_DAY = "Journée";
    const TYPE_LABEL_HALF_DAY = "Demi-journée";
    const HALF_DAY_COEFF = 0.5;
    const TYPE_DAY = true;
    const TYPE_HALF_DAY = false;
    const NOT_AFTERNOON_HOUR = 14;
    const TOO_LATE_HOUR_DAY = "16:30";
    const TOO_LATE_HOUR_NIGHT = "20:00";

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThanOrEqual("today")
     * @NotTuesday()
     * @NotSunday()
     * @NotHoliday()
     */
    private $dateOfVisit;

    /**
     * @ORM\Column(type="boolean")
     */
    private $period;

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $numberOfPeople;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;



    /**
     * @ORM\Column(type="integer")
     */
    private $price = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="booking", orphanRemoval=true, cascade={"persist"})
     */
    private $tickets;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOfVisit(): ?\DateTimeInterface
    {
        return $this->dateOfVisit;
    }

    public function setDateOfVisit(\DateTimeInterface $dateOfVisit): self
    {
        $this->dateOfVisit = $dateOfVisit;

        return $this;
    }

    public function getPeriod(): ?bool
    {
        return $this->period;
    }

    public function getPeriodLabel(): string
    {
        return $this->period ? self::TYPE_LABEL_DAY : self::TYPE_LABEL_HALF_DAY;
    }

    public function setPeriod(bool $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function getNumberOfPeople(): ?int
    {
        return $this->numberOfPeople;
    }

    public function setNumberOfPeople(int $numberOfPeople): self
    {
        $this->numberOfPeople = $numberOfPeople;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {

        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setBooking($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getBooking() === $this) {
                $ticket->setBooking(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }




}
