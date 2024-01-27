<?php

declare(strict_types=1);

namespace models;

class Utilisateur
{
    private int $idU;
    private string $nom;
    private string $password;

    private bool $admin;

    public function __construct(int $idU, string $nom, string $password, bool $admin)
    {
        $this->idU = $idU;
        $this->nom = $nom;
        $this->password = $password;
        $this->admin = $admin;
    }


    public function getIdU(): int
    {
        return $this->idU;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAdmin(): bool
    {
        return $this->admin;
    }

    public function setIdU(int $idU): void
    {
        $this->idU = $idU;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setAdmin(bool $admin): void
    {
        $this->admin = $admin;
    }

    public function __toString(): string
    {
        return "Utilisateur : " . $this->idU . " " . $this->nom . " " . $this->password . " " . $this->admin;
    }

}
