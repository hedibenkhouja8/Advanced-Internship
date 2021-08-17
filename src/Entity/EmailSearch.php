<?php
namespace App\Entity;

    class EmailSearch{

  /**
             * @var string|null
             */
            private $email;

            /**
                   * @return string|null
                   */
                  public function getemail(): ?string {
          
                      return $this->email;
                  }
          
                  /**
                   * @param string|null $email
                   * @return EmailSearch
                   */
                  public function setemail(string $email):EmailSearch
                  {
                      $this->email = $email;
                      return $this;
          
                  }

                }