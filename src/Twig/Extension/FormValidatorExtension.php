<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * UserProvider: craig
 * Date: 23/11/2018
 * Time: 15:27
 */
namespace App\Twig\Extension;

use App\Manager\FormValidatorManager;
use Twig\Extension\AbstractExtension;

class FormValidatorExtension extends AbstractExtension
{
    /**
     * @var FormValidatorManager
     */
    private $manager;

    /**
     * @return string
     */
    public function getName()
    {
        return 'form_validator_extension';
    }

    /**
     * FormValidatorExtension constructor.
     * @param FormValidatorManager $manager
     */
    public function __construct(FormValidatorManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * getFunctions
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('renderValidatorScript', array($this->manager, 'renderValidatorScript'), ['is_safe' => ['html']]),
        ];
    }

}