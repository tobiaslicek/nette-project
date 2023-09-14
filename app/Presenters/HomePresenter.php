<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;



final class HomePresenter extends Nette\Application\UI\Presenter
{
  public function __construct(
    private Nette\Database\Explorer $database,
  ) {
  }

  public function renderDefault(): void
  {
    $this->template->posts = $this->database
      ->table('posts')
      ->order('created_at DESC')
      ->limit(5);
  }
}
