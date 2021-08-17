<?php
namespace App\Entity;

    class InventorySearch{

 /**
             * @var string|null
             */
            private $location;

            /**
                   * @return string|null
                   */
                  public function getlocation(): ?string {
          
                      return $this->location;
                  }
          
                  /**
                   * @param string|null $location
                   * @return InventorySearch
                   */
                  public function setlocation(string $location):InventorySearch
                  {
                      $this->location = $location;
                      return $this;
          
                  }
                   /**
             * @var string|null
             */
            private $operatingsystem;

            /**
                   * @return string|null
                   */
                  public function getoperatingsystem(): ?string {
          
                      return $this->operatingsystem;
                  }
          
                  /**
                   * @param string|null $operatingsystem
                   * @return InventorySearch
                   */
                  public function setoperatingsystem(string $operatingsystem):InventorySearch
                  {
                      $this->operatingsystem = $operatingsystem;
                      return $this;
          
                  }
                   /**
             * @var string|null
             */
            private $state;

            /**
                   * @return string|null
                   */
                  public function getstate(): ?string {
          
                      return $this->state;
                  }
          
                  /**
                   * @param string|null $state
                   * @return InventorySearch
                   */
                  public function setstate(string $state):InventorySearch
                  {
                      $this->state = $state;
                      return $this;
          
                  }
                   /**
             * @var string|null
             */
            private $brand;

            /**
                   * @return string|null
                   */
                  public function getbrand(): ?string {
          
                      return $this->brand;
                  }
          
                  /**
                   * @param string|null $brand
                   * @return InventorySearch
                   */
                  public function setbrand(string $brand):InventorySearch
                  {
                      $this->brand = $brand;
                      return $this;
          
                  }



























    }