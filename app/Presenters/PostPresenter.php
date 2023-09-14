<?php
namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

final class PostPresenter extends Nette\Application\UI\Presenter
{
	public function __construct(
		private Nette\Database\Explorer $database,
	) {
	}

	public function renderShow(int $postId): void
	{
		$this->template->post = $this->database
			->table('posts')
			->get($postId);
	}
}
