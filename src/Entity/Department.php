<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentRepository")
 */
class Department
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $department;

    /**
     * @ORM\OneToMany(targetEntity="Manager", mappedBy="dept_id")
     */
    private $manager;

    public function __construct()
    {
        $this->manager = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Collection|Manager[]
     */
    public function getManager(): Collection
    {
        return $this->manager;
    }

    public function addManager(Manager $manager): self
    {
        if (!$this->manager->contains($manager)) {
            $this->manager[] = $manager;
            $manager->setDeptId($this);
        }

        return $this;
    }

    public function removeManager(Manager $manager): self
    {
        if ($this->manager->contains($manager)) {
            $this->manager->removeElement($manager);
            // set the owning side to null (unless already changed)
            if ($manager->getDeptId() === $this) {
                $manager->setDeptId(null);
            }
        }

        return $this;
    }
}
