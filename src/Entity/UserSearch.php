<?php
namespace App\Entity;

    class UserSearch{

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
                   * @return UserSearch
                   */
                  public function setuser(string $user):UserSearch
                  {
                      $this->user = $user;
                      return $this;
          
                  }

                }