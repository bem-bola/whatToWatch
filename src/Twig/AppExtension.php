<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('transformMinutesHours', [$this, 'transformMinutesHours']),
            new TwigFunction('wordLorem', [$this, 'wordLorems']),
        ];
    }

    public function transformMinutesHours(int $value)
    {
        $n;
        $h;
        $m;

        if($value < 60){
            $n = $value . " min";
        }else{
            $m = $value % 60;
            $h = floor($value / 60);
            $n = $h . "h" . $m ."min";
        }
        return $n;
    }

    public function wordLorems(string $string ){

        $result ="";
       
        $x = 0;
        $test = explode(' ', $string);

        if(str_word_count($string, 0) > 20){
           $x += 20;
        }else{
            $x +=  str_word_count($string, 0);
        }

        for ($i = 0; $i < $x; $i++){

            $result .= "$test[$i] ";
        }

        return $result . "...";

    }
}
