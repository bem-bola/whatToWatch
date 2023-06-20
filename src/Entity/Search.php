<?php

namespace App\Entity;

use App\Entity;

class Search
{

   private $titles;

   
   public function getTitles(): ?string
   {
       return $this->titles;
   }

   public function setTitles(string $titles): self
   {
       $this->titles = $titles;

       return $this;
   }
}