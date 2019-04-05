<?php
namespace App\Twig\Extension;

use App\Manager\MessageManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class FlashExtension
 * @package App\Twig\Extension
 */
class FlashExtension extends AbstractExtension
{
	/**
	 * @var array
	 */
	private $flashMessage = [];

	/**
	 * @var MessageManager
	 */
	private $messageManager;

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'flash_extension';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFunctions()
	{
		return [
			new TwigFunction('showFlash', [$this, 'showFlash']),
			new TwigFunction('getMessageManager', [$this, 'getMessageManager']),
		];
	}

	/**
	 * @param   string $value
	 *
	 * @return  bool
	 */
	public function showFlash($value): bool
	{
		if (in_array($value, $this->flashMessage))
			return false;

		$this->flashMessage[] = $value;

		return true;
	}

	/**
	 * FlashExtension constructor.
	 *
	 * @param MessageManager $messageManager
	 */
	public function __construct(MessageManager $messageManager)
	{
		$this->messageManager = $messageManager;
	}

	/**
	 * @return MessageManager
	 */
	public function getMessageManager()
	{
		return $this->messageManager;
	}
}