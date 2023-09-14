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
    $post = $this->database
      ->table('posts')
      ->get($postId);
    if (!$post) {
      $this->error('Stránka nebyla nalezena');
    }

    $this->template->post = $post;
  }

  protected function createComponentCommentForm(): Form
  {
    $form = new Form; // means Nette\Application\UI\Form

    $form->addText('name', 'Jméno:')
      ->setRequired();

    $form->addEmail('email', 'E-mail:');

    $form->addTextArea('content', 'Komentář:')
      ->setRequired();

    $form->addSubmit('send', 'Publikovat komentář');

    return $form;
  }
}
