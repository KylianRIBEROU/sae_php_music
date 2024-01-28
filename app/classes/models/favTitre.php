<?php 

declare(strict_types=1);

namespace models;

class favTitre { 
    
        private int $idU;
    
        private int $idT;
    
        /**
        * favTitre constructor, association entre un titre et un utilisateur, manyToMany
        * @param int $idU
        * @param int $idT
        */
        public function __construct(int $idU, int $idT) {
            $this->idU = $idU;
            $this->idT = $idT;
        }
    
        /**
        * @return int
        */
        public function getIdU(): int {
            return $this->idU;
        }
    
        /**
        * @return int
        */
        public function getIdT(): int {
            return $this->idT;
        }
    
        /**
        * @param int $idU
        * @return void
        */
        public function setIdU(int $idU): void {
            $this->idU = $idU;
    
        }
    
        /**
        * @param int $idT
        * @return void
        */
        public function setIdT(int $idT): void {
            $this->idT = $idT;
        }
}