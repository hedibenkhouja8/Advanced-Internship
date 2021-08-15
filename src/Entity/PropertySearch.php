<?php
namespace App\Entity;

    class PropertySearch{

            /**
             * @var string|null
             */
        private $manufacturer;

           /**
             * @var string|null
             */
            private $stockingarea;


        /**
         * @var int|null
         */
        private $minQuantity;


        /**
         * @return int|null
         */
        public function getminQuantity(): ?int {

            return $this->minQuantity;
        }

        /**
         * @param int|null $minQuantity
         * @return PropertySearch
         */
        public function setminQuantity(int $minQuantity):PropertySearch
        {
            $this->minQuantity = $minQuantity;
            return $this;

        }

          /**
          * @return string|null
          */
        public function getmanufacturer(): ?string {

            return $this->manufacturer;
        }

        /**
         * @param string|null $manufacturer
         * @return PropertySearch
         */
        public function setmanufacturer(string $manufacturer):PropertySearch
        {
            $this->manufacturer = $manufacturer;
            return $this;

        }


          /**
          * @return string|null
          */
          public function getstockingarea(): ?string {

            return $this->stockingarea;
        }

        /**
         * @param string|null $stockingarea
         * @return PropertySearch
         */
        public function setstockingarea(string $stockingarea):PropertySearch
        {
            $this->stockingarea = $stockingarea;
            return $this;

        }

    }