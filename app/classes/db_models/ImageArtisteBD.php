<?php

declare(strict_types=1);

namespace db_models;

use PDO;

use pdoFactory\PDOFactory;

class ImageArtisteBD
{
   /**
     * Crée une nouvelle image d'artiste dans la base de données.
     *
     * @param ImageArtiste $imageArtiste
     * @return bool True si l'image d'artiste a été créée avec succès, sinon false.
     */
    public function createImageArtiste(ImageArtiste $imageArtiste): bool
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = 'INSERT INTO image (lienImage, pos, idA) VALUES (:lienImage, :pos, :idA)';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':lienImage', $imageArtiste->getLienImage());
            $stmt->bindValue(':pos', $imageArtiste->getPos());
            $stmt->bindValue(':idA', $imageArtiste->getIdA());
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * Récupère une image d'artiste par ID depuis la base de données.
     *
     * @param int $idImage L'ID de l'image d'artiste.
     * @return ImageArtiste|null L'objet image d'artiste récupéré, ou null s'il n'est pas trouvé.
     */
    public function getImageArtisteById(int $idImage): ?ImageArtiste
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = 'SELECT * FROM image WHERE idImage = :idImage';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idImage', $idImage);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return new ImageArtiste(
                    (int)$result['idImage'],
                    $result['lienImage'],
                    (int)$result['pos'],
                    (int)$result['idA']
                );
            }

            return null;
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return null;
        }
    }

    /**
     * Met à jour une image d'artiste dans la base de données.
     *
     * @param ImageArtiste $imageArtiste L'objet image d'artiste mis à jour.
     * @return bool True si l'image d'artiste a été mise à jour avec succès, sinon false.
     */
    public function updateImageArtiste(ImageArtiste $imageArtiste): bool
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = 'UPDATE image SET lienImage = :lienImage, pos = :pos, idA = :idA WHERE idImage = :idImage';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idImage', $imageArtiste->getIdImage());
            $stmt->bindValue(':lienImage', $imageArtiste->getLienImage());
            $stmt->bindValue(':pos', $imageArtiste->getPos());
            $stmt->bindValue(':idA', $imageArtiste->getIdA());
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * Supprime une image d'artiste de la base de données.
     *
     * @param int $idImage L'ID de l'image d'artiste à supprimer.
     * @return bool True si l'image d'artiste a été supprimée avec succès, sinon false.
     */
    public function deleteImageArtiste(int $idImage): bool
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = 'DELETE FROM image WHERE idImage = :idImage';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idImage', $idImage);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * Récupère toutes les images d'artiste associées à un artiste depuis la base de données.
     *
     * @param int $idA L'ID de l'artiste.
     * @return array La liste des images d'artiste récupérées.
     */
    public function getAllImageByArtiste(int $idA): array
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = 'SELECT * FROM image WHERE idA = :idA';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idA', $idA);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $images = [];

            foreach ($result as $image) {
                $images[] = new ImageArtiste(
                    (int)$image['idImage'],
                    $image['lienImage'],
                    (int)$image['pos'],
                    (int)$image['idA']
                );
            }

            return $images;
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return [];
        }
    }

    /**
     * Supprime toutes les images d'artiste associées à un artiste de la base de données.
     * 
     * @param int $idA L'ID de l'artiste.
     * @return bool True si les images ont été supprimées avec succès, sinon false.
     */
    public function deleteAllImageByArtiste(int $idA): bool
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = 'DELETE FROM image WHERE idA = :idA';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idA', $idA);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }
}

class ImageArtiste {

    private int $idImage;

    private string $lienImage;

    private int $pos;

    private int $idA;

    /**
     * ImageArtiste constructor.
     * @param int $idImage
     * @param string $lienImage
     * @param int $pos
     * @param int $idA
     */
    public function __construct(int $idImage, string $lienImage, int $pos, int $idA)
    {
        $this->idImage = $idImage;
        $this->lienImage = $lienImage;
        $this->pos = $pos;
        $this->idA = $idA;
    }

    /**
     * @return int
     */
    public function getIdImage(): int
    {
        return $this->idImage;
    }

    /**
     * @return string
     */
    public function getLienImage(): string
    {
        return $this->lienImage;
    }

    /**
     * @return int
     */
    public function getPos(): int
    {
        return $this->pos;
    }

    /**
     * @return int
     */
    public function getIdA(): int
    {
        return $this->idA;
    }

    /**
     * @param int $idImage
     */
    public function setIdImage(int $idImage): void
    {
        $this->idImage = $idImage;
    }

    /**
     * @param string $lienImage
     */
    public function setLienImage(string $lienImage): void
    {
        $this->lienImage = $lienImage;
    }

    /**
     * @param int $pos
     */
    public function setPos(int $pos): void
    {
        $this->pos = $pos;
    }

    /**
     * @param int $idA
     */
    public function setIdA(int $idA): void
    {
        $this->idA = $idA;
    }

    public function __toString(): string
    {
        return "ImageArtiste : $this->idImage, $this->lienImage, $this->pos, $this->idA";
    }
    
}
