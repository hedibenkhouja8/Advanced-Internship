<?php
namespace App\Entity;

    class LicenceSearch{

            /**
             * @var string|null
             */
        private $category;

  /**
         * @return string|null
         */
        public function getcategory(): ?string {

            return $this->category;
        }

        /**
         * @param string|null $category
         * @return LicenceSearch
         */
        public function setcategory(string $category):LicenceSearch
        {
            $this->category = $category;
            return $this;

        }

         /**
             * @var string|null
             */
            private $user;

            /**
                   * @return string|null
                   */
                  public function getuser(): ?string {
          
                      return $this->user;
                  }
          
                  /**
                   * @param string|null $user
                   * @return LicenceSearch
                   */
                  public function setuser(string $user):LicenceSearch
                  {
                      $this->user = $user;
                      return $this;
          
                  }

                    /**
             * @var string|null
             */
            private $compilancetype;

            /**
                   * @return string|null
                   */
                  public function getcompilancetype(): ?string {
          
                      return $this->compilancetype;
                  }
          
                  /**
                   * @param string|null $compilancetype
                   * @return LicenceSearch
                   */
                  public function setcompilancetype(string $compilancetype):LicenceSearch
                  {
                      $this->compilancetype = $compilancetype;
                      return $this;
          
                  }
    }