<?php
declare(strict_types=1);

namespace dataloader;

/**
 * Interface LoaderInterface
 * Interface pour les classes de chargement de données ici JsonLoader et DBLoader
 */
interface LoaderInterface
{
    /**
     * Récupère les données
     * @return array
     */
    public function getData(): array;
}